# DB仕様書
- 型は MySQL 想定（Laravel のマイグレーションで表現可能な範囲）。
- 

---

## users（ユーザー）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `name` | string | **20文字以内**（登録要件） |
| `email` | string | **UNIQUE** |
| `password` | string | ハッシュ格納 |
| `email_verified_at` | timestamp | nullable |
| `remember_token` | string | nullable |
| `created_at` / `updated_at` | timestamp |  |

---

## categories（カテゴリ）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `name` | string |  |
| `slug` | string | **UNIQUE**（URL等で使用） |
| `created_at` / `updated_at` | timestamp |  |

---

## items（商品）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `user_id` | bigint **FK** | `users(id)` 出品者 |
| `category_id` | bigint **FK** | `categories(id)` |
| `title` | string |  |
| `description` | text |  |
| `price` | **unsigned int** | 0以上 |
| `status` | string(10) | `active` / `sold` |
| `image_path` | string | サムネ1枚、nullable |
| `created_at` / `updated_at` | timestamp |  |

---

## addresses（住所）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `user_id` | bigint **FK** | `users(id)` 所有者 |
| `postal` | string(8) | 例 `123-4567` |
| `prefecture` | string(64) |  |
| `city` | string(128) |  |
| `line1` | string(255) | 番地・建物 |
| `line2` | string(255) | 号室など、nullable |
| `phone` | string(20) | nullable |
| `is_default` | boolean | 既定住所、default false |
| `created_at` / `updated_at` | timestamp |  |

---

## orders（注文・単品購入）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `buyer_id` | bigint **FK** | `users(id)` 購入者 |
| `item_id` | bigint **FK** | `items(id)` |
| `address_id` | bigint **FK** | `addresses(id)` |
| `price` | **unsigned int** | 購入時価格 |
| `qty` | **unsigned int** | 既定1 |
| `status` | string(12) | `pending` / `paid` / `canceled` |
| `ordered_at` | datetime | nullable |
| `created_at` / `updated_at` | timestamp |  |

---

## comments（コメント）

| カラム | 型 | 備考 |
|---|---|---|
| `id` | bigint **PK** |  |
| `user_id` | bigint **FK** | `users(id)` 投稿者 |
| `item_id` | bigint **FK** | `items(id)` 対象商品 |
| `body` | string(255) |  |
| `created_at` / `updated_at` | timestamp |  |

---

### インデックス/制約メモ（実装時）
- `users.email` と `categories.slug` に **UNIQUE**。
- 外部キーは各 `*_id` に設定（`cascadeOnDelete()` 推奨）。
- `orders.qty` は `d
