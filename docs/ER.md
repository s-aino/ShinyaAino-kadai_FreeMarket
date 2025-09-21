# ER 図

```mermaid
erDiagram
  %% Notes:
  %% - UNIQUE: USERS.email, CATEGORIES.slug
  %% - ITEMS.image_path はサムネ1枚
  %% - status の値: active|sold / pending|paid|canceled など想定

  USERS {
    bigint   id PK
    string   name
    string   email
    string   password
    datetime email_verified_at
    string   remember_token
    datetime created_at
    datetime updated_at
  }

  CATEGORIES {
    bigint   id PK
    string   name
    string   slug
    datetime created_at
    datetime updated_at
  }

  ITEMS {
    bigint   id PK
    bigint   user_id FK
    bigint   category_id FK
    string   title
    text     description
    int      price
    string   status
    string   image_path
    datetime created_at
    datetime updated_at
  }

  ADDRESSES {
    bigint   id PK
    bigint   user_id FK
    string   postal
    string   prefecture
    string   city
    string   line1
    string   line2
    string   phone
    boolean  is_default
    datetime created_at
    datetime updated_at
  }

  ORDERS {
    bigint   id PK
    bigint   buyer_id FK
    bigint   item_id FK
    bigint   address_id FK
    int      price
    int      qty
    string   status
    datetime ordered_at
    datetime created_at
    datetime updated_at
  }

  COMMENTS {
    bigint   id PK
    bigint   user_id FK
    bigint   item_id FK
    string   body
    datetime created_at
    datetime updated_at
  }

  %% Relations
  USERS      ||--o{ ITEMS     : hasMany
  USERS      ||--o{ ADDRESSES : hasMany
  USERS      ||--o{ COMMENTS  : hasMany
  CATEGORIES ||--o{ ITEMS     : hasMany

  ITEMS      }o--|| USERS      : belongsTo
  ITEMS      }o--|| CATEGORIES : belongsTo
  COMMENTS   }o--|| USERS      : belongsTo
  COMMENTS   }o--|| ITEMS      : belongsTo

  ORDERS     }o--|| USERS      : buyer_id
  ORDERS     }o--|| ITEMS      : item_id
  ORDERS     }o--|| ADDRESSES  : ship_to
