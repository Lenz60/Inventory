CREATE TABLE users (
  id varchar(255),
  name varchar(255),
  password varchar(255),
  remember_token varchar(255),
  created_at timestamp,
  updated_at timestamp
);

CREATE TABLE admin (
  id varchar(255),
  name varchar(255),
  password varchar(255),
  role number,
  remember_token varchar(255),
  created_at timestamp,
  updated_at timestamp
);

-- Role 1 is master admin can add admin and delete admin except himself
-- Role 2 is regullar admin that can be filled CRUD data

CREATE TABLE furniture (
  id varchar(255),
  picture varchar(255),
  code varchar(255),
  description varchar(255),
  category ENUM(`Indoor`,`Outdoor`,`Handicraft`,`Root`),
  wood_type ENUM(`Teak wood`,`Tiger wood`,`Mahogany wood`,`Root`),
  width varchar(255),
  depth varchar(255),
  height varchar(255),
  price float,
  created_at timestamp,
  updated_at timestamp
);

-- Hardcode Wood type
-- Set if the category is selected root, then the available wood type is only Root


CREATE TABLE orders (
  id varchar(255),
  user_id varchar(255),
  furniture_id varchar(255),
  qty number,
  total_price float
);

ALTER TABLE furniture ADD FOREIGN KEY (id) REFERENCES orders (furniture_id);

ALTER TABLE orders ADD FOREIGN KEY (user_id) REFERENCES users (id);
