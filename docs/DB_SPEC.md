# DB仕様書（骨子） / Flea Market App

最終更新: 2025-09-14
目的: 画面ワイヤーとER図に基づく**最小テーブル仕様**のアウトライン。後で詳細（制約・DDL）を肉付け。

---

## 表記ルール（型・必須）

* 型は MySQL 想定（Laravel のマイグレーションで表現可能な範囲）。
* `必須` はアプリ要件上の必須。DBのNOT NULL/DEFAULTは今後確定。
* `FK` は外部キー参照。物理FKの有無は後で選択（開発速度優先ならインデックスのみ→後でFK追加）。

---

## users（ユーザー）

| カラム名                | 型            | 必須  | 備考                                      |
| ------------------- | ------------ | --- | --------------------------------------- |
| id                  | BIGINT       | はい  | PK                                      |
| name                | VARCHAR(50)  | はい  | 表示名                                     |
| email               | VARCHAR(255) | はい  | ログインID。**UNIQUE**                       |
| password            | VARCHAR(255) | はい  | パスワードハッシュ                               |
| avatar\_path        | VARCHAR(255) | いいえ | プロフィール画像の相対パス（`storage/app/public/...`） |
| email\_verified\_at | DATETIME     | いいえ | メール認証の完了日時（将来のため）                       |
| created\_at         | DATETIME     | はい  |                                         |
| updated\_at         | DATETIME     | はい  |                                         |

**インデックス候補**: `UNIQUE(email)`

---

## items（商品）

| カラム名         | 型                | 必須  | 備考                                                  |
| ------------ | ---------------- | --- | --------------------------------------------------- |
| id           | BIGINT           | はい  | PK                                                  |
| user\_id     | BIGINT           | はい  | 出品者ユーザーID（FK: users.id）                             |
| category\_id | BIGINT           | いいえ | FK: categories.id                                   |
| title        | VARCHAR(120)     | はい  | 商品名                                                 |
| brand        | VARCHAR(60)      | いいえ | ブランド名                                               |
| description  | TEXT             | いいえ | 商品説明                                                |
| price        | INT UNSIGNED     | はい  | 価格（円・税込・整数）                                         |
| condition    | TINYINT UNSIGNED | いいえ | 状態 0..4（0:新品、1:未使用に近い、2:目立った傷や汚れなし、3:やや傷/汚れ、4:傷/汚れ） |
| status       | TINYINT UNSIGNED | はい  | 0=下書き, 1=公開, 2=売却済み（初期値:1想定）                        |
| created\_at  | DATETIME         | はい  |                                                     |
| updated\_at  | DATETIME         | はい  |                                                     |
| deleted\_at  | DATETIME         | いいえ | 論理削除                                                |

**インデックス候補**: `(status, created_at)`, `price`, `user_id`, `category_id`

---

## item\_images（商品画像）

| カラム名        | 型                | 必須 | 備考                       |
| ----------- | ---------------- | -- | ------------------------ |
| id          | BIGINT           | はい | PK                       |
| item\_id    | BIGINT           | はい | FK: items.id             |
| path        | VARCHAR(255)     | はい | 画像パス（`public/items/...`） |
| is\_primary | TINYINT(1)       | はい | サムネか（0/1）                |
| sort\_order | TINYINT UNSIGNED | はい | 並び順（0開始）                 |
| created\_at | DATETIME         | はい |                          |
| updated\_at | DATETIME         | はい |                          |

**インデックス候補**: `(item_id, is_primary)`

---

## categories（カテゴリ）

| カラム名        | 型            | 必須  | 備考            |
| ----------- | ------------ | --- | ------------- |
| id          | BIGINT       | はい  | PK            |
| name        | VARCHAR(100) | はい  | カテゴリ名         |
| parent\_id  | BIGINT       | いいえ | 親カテゴリ（自己参照FK） |
| created\_at | DATETIME     | はい  |               |
| updated\_at | DATETIME     | はい  |               |

**インデックス候補**: `name`, `parent_id`

---

## favorites（お気に入り）

| カラム名        | 型        | 必須 | 備考           |
| ----------- | -------- | -- | ------------ |
| id          | BIGINT   | はい | PK           |
| user\_id    | BIGINT   | はい | FK: users.id |
| item\_id    | BIGINT   | はい | FK: items.id |
| created\_at | DATETIME | はい |              |
| updated\_at | DATETIME | はい |              |

**制約**: `UNIQUE(user_id, item_id)`（同一商品の重複お気に入りを禁止）

---

## comments（コメント）

| カラム名        | 型        | 必須 | 備考           |
| ----------- | -------- | -- | ------------ |
| id          | BIGINT   | はい | PK           |
| user\_id    | BIGINT   | はい | FK: users.id |
| item\_id    | BIGINT   | はい | FK: items.id |
| body        | TEXT     | はい | 本文           |
| created\_at | DATETIME | はい |              |
| updated\_at | DATETIME | はい |              |

**インデックス候補**: `(item_id, created_at)`

---

## orders（注文）

| カラム名                  | 型                | 必須  | 備考                             |
| --------------------- | ---------------- | --- | ------------------------------ |
| id                    | BIGINT           | はい  | PK                             |
| user\_id              | BIGINT           | はい  | 購入者（FK: users.id）              |
| shipping\_address\_id | BIGINT           | いいえ | 送付先（FK: addresses.id）          |
| total\_amount         | INT UNSIGNED     | はい  | 注文合計（円）                        |
| status                | TINYINT UNSIGNED | はい  | 0=保留,1=支払い済,2=発送済,3=完了,9=キャンセル |
| paid\_at              | DATETIME         | いいえ | 支払い完了日時                        |
| created\_at           | DATETIME         | はい  |                                |
| updated\_at           | DATETIME         | はい  |                                |

**インデックス候補**: `user_id`, `(status, created_at)`

---

## order\_items（注文明細）

| カラム名        | 型                 | 必須 | 備考               |
| ----------- | ----------------- | -- | ---------------- |
| id          | BIGINT            | はい | PK               |
| order\_id   | BIGINT            | はい | FK: orders.id    |
| item\_id    | BIGINT            | はい | FK: items.id     |
| price       | INT UNSIGNED      | はい | 購入時の単価（スナップショット） |
| quantity    | SMALLINT UNSIGNED | はい | 数量               |
| created\_at | DATETIME          | はい |                  |
| updated\_at | DATETIME          | はい |                  |

**インデックス候補**: `order_id`, `item_id`

---

## addresses（住所）

| カラム名         | 型            | 必須  | 備考                   |
| ------------ | ------------ | --- | -------------------- |
| id           | BIGINT       | はい  | PK                   |
| user\_id     | BIGINT       | はい  | 所有ユーザー（FK: users.id） |
| postal\_code | VARCHAR(16)  | いいえ | 郵便番号                 |
| prefecture   | VARCHAR(50)  | いいえ | 都道府県                 |
| city         | VARCHAR(100) | いいえ | 市区町村                 |
| address1     | VARCHAR(100) | いいえ | 番地                   |
| address2     | VARCHAR(100) | いいえ | 建物名・部屋番号             |
| phone        | VARCHAR(20)  | いいえ | 電話番号                 |
| is\_default  | TINYINT(1)   | はい  | 既定住所フラグ（0/1）         |
| created\_at  | DATETIME     | はい  |                      |
| updated\_at  | DATETIME     | はい  |                      |

**インデックス候補**: `(user_id, is_default)`

---

## 追加メモ（後で決めること）

* 物理FKの有効化範囲（全テーブルに張るか、段階導入か）
* ENUM/チェック制約の表現（MySQL ではアプリ層で担保でもOK）
* 検索のための **FULLTEXT**（`items(title, description)`）導入の要否
* 大量データに備えたアーカイブ方針（`deleted_at` で吸収 / 別テーブル）

---

## 付記

* 本書は骨子です。確定後にDDL（マイグレーション）へ反映し、**DB差分は都度この表に戻し反映**します。
