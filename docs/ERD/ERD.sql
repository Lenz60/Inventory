CREATE TABLE users (
  id varchar(255) PRIMARY KEY,
  name varchar(255),
  password varchar(255),
  remember_token varchar(255),
  created_at timestamp,
  updated_at timestamp
);

CREATE TABLE admin (
  id varchar(255) PRIMARY KEY,
  username varchar(255),
  password varchar(255),
  name varchar(255),
  role number,
  created_at timestamp,
  updated_at timestamp
);

CREATE TABLE furniture (
  id varchar(255) PRIMARY KEY,
  image varchar(255),
  code varchar(255),
  description varchar(255),
  category ENUM('Indoor', 'Outdoor', 'Handicraft', 'Root'),
  wood_type ENUM('Teak wood', 'Tiger wood', 'Mahogany wood', 'Root'),
  width varchar(255),
  depth varchar(255),
  height varchar(255),
  stock int,
  price float,
  created_at timestamp,
  updated_at timestamp
);

CREATE TABLE orders (
  id varchar(255) PRIMARY KEY,
  cart_id varchar(255),
  qty number,
  total_price float
);

CREATE TABLE orders_payment (
  id varchar(255) PRIMARY KEY,
  order_id varchar(255),
  payment_status varchar(255)
);

CREATE TABLE orders_production (
  id varchar(255) PRIMARY KEY,
  order_id varchar(255),
  production_status varchar(255)
);

CREATE TABLE cart (
  id varchar(255) PRIMARY KEY,
  user_id varchar(255),
  furniture_id varchar(255),
  qty number,
  total_price float
);

ALTER TABLE orders ADD FOREIGN KEY (cart_id) REFERENCES cart (id);

ALTER TABLE orders_payment ADD FOREIGN KEY (order_id) REFERENCES orders (id);

ALTER TABLE orders_production ADD FOREIGN KEY (order_id) REFERENCES orders (id);

ALTER TABLE furniture ADD FOREIGN KEY (id) REFERENCES cart (furniture_id);

ALTER TABLE cart ADD FOREIGN KEY (user_id) REFERENCES users (id);
