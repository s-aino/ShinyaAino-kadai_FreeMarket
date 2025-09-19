# DB仕様書（骨子） / Free Market App

目的: 画面ワイヤーとER図に基づく**最小テーブル仕様**のアウトライン。後で詳細（制約・DDL）を肉付け。

---

## 表記ルール（型）

* 型は MySQL 想定（Laravel のマイグレーションで表現可能な範囲）。



---

## users（ユーザー）

| カラム                    | 型        | 備考                       |
| ------------------------- | --------- | -------------------------- |
| id                        | bigint PK |                            |
| name                      | string    | **20文字以内**（登録要件） |
| email                     | string    | UNIQUE                     |
| password                  | string    |                            |
| avatar\_path              | string    | nullable                   |
| email\_verified\_at       | timestamp | nullable                   |
| remember\_token           | string    | nullable                   |
| created\_at / updated\_at | timestamp |                            |

---

## profiles

| カラム        | 型        | 備考                                  |
| ------------- | --------- | ------------------------------------- |
| id            | bigint PK |                                       |
| user\_id      | bigint FK | **UNIQUE**（1ユーザー=1プロフィール） |
| display\_name | string    | nullable, ～20                        |
| bio           | string    | nullable, ～255                       |
| website\_url  | string    | nullable                              |
| birthdate     | date      | nullable                              |
| timestamps    |           |                                       |

---
## categories

| カラム     | 型        | 備考                 |
| ---------- | --------- | -------------------- |
| id         | bigint PK |                      |
| name       | string    |                      |
| slug       | string    | UNIQUE               |
| parent\_id | bigint FK | nullable（自己参照） |

---
## items

| カラム        | 型        | 備考              |      |          |
| ------------- | --------- | ----------------- | ---- | -------- |
| id            | bigint PK |                   |      |          |
| user\_id      | bigint FK | 出品者            |      |          |
| category\_id  | bigint FK |                   |      |          |
| title         | string    |                   |      |          |
| description   | text      | ～2000想定        |      |          |
| price         | int       | 0以上             |      |          |
| status        | string    | \`active          | sold | paused\` |
| condition     | tinyint   | 1..5 等、nullable |      |          |
| published\_at | timestamp | nullable          |      |          |
| timestamps    |           |                   |      |          |

---
## item_images

| カラム         | 型                | 備考        |
| ----------- | ---------------- | --------- |
| id          | bigint PK        |           |
| item\_id    | bigint FK        |           |
| path        | string           |           |
| sort\_order | unsignedSmallInt | default 0 |
| timestamps  |                  |           |

---
## favorites

| カラム        | 型         | 備考                             |
| ---------- | --------- | ------------------------------ |
| id         | bigint PK | （不要なら無しでもOK）                   |
| user\_id   | bigint FK |                                |
| item\_id   | bigint FK |                                |
| timestamps |           |                                |
| 制約         |           | **UNIQUE(user\_id, item\_id)** |

---
## orders

| カラム           | 型         | 備考           |      |          |            |
| ------------- | --------- | ------------ | ---- | -------- | ---------- |
| id            | bigint PK |              |      |          |            |
| buyer\_id     | bigint FK | users.id     |      |          |            |
| address\_id   | bigint FK | addresses.id |      |          |            |
| total\_amount | int       |              |      |          |            |
| status        | string    | \`pending    | paid | canceled | refunded\` |
| ordered\_at   | timestamp |              |      |          |            |
| timestamps    |           |              |      |          |            |

---
## order_item

| カラム        | 型         | 備考                 |
| ---------- | --------- | ------------------ |
| id         | bigint PK |                    |
| order\_id  | bigint FK |                    |
| item\_id   | bigint FK |                    |
| price      | int       | **購入時価格のスナップショット** |
| qty        | int       |                    |
| timestamps |           |                    |

---
## addresses

| カラム         | 型         | 備考            |
| ----------- | --------- | ------------- |
| id          | bigint PK |               |
| user\_id    | bigint FK |               |
| postal      | string(8) | 例 `123-4567`  |
| prefecture  | string    |               |
| city        | string    |               |
| line1       | string    |               |
| line2       | string    | nullable      |
| phone       | string    | nullable      |
| is\_default | boolean   | default false |
| timestamps  |           |               |

---
## comments

| カラム        | 型           | 備考 |
| ---------- | ----------- | -- |
| id         | bigint PK   |    |
| user\_id   | bigint FK   |    |
| item\_id   | bigint FK   |    |
| body       | string(255) |    |
| timestamps |             |    |


## 追加メモ（後で決めること）

* 物理FKの有効化範囲（全テーブルに張るか、段階導入か）
* ENUM/チェック制約の表現（MySQL ではアプリ層で担保でもOK）
* 検索のための **FULLTEXT**（`items(title, description)`）導入の要否
* 大量データに備えたアーカイブ方針（`deleted_at` で吸収 / 別テーブル）

---

## 付記

* 本書は骨子です。確定後にDDL（マイグレーション）へ反映し、**DB差分は都度この表に戻し反映**します。
