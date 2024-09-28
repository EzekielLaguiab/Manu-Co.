
-- orders items table
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB CHARSET=latin1;

-- users table
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(108) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UX_Constraint` (`user_email`)
) ENGINE=InnoDB CHARSET=latin1;

-- orders table
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB CHARSET=latin1;


-- products table
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(108) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image2` varchar(255),
  `product_image3` varchar(255),
  `product_image4` varchar(255),
  `product_price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB CHARSET=latin1;


-- insert products
INSERT INTO `products`
(`product_name`,
`product_category`,`product_description`, 
`product_image`,`product_image2`, `product_image3`,
 `product_image4`,`product_price`)
 VALUES 
  ('Custom 2', 'category6',"Good quality at good price", 
  'custom2.jpg','','','', 
  200),
    ('Custom 3', 'category7',"Good quality at good price", 
  'custom3.jpg','','','', 
  200),
    ('Custom 4', 'category8',"Good quality at good price", 
  'custom4.jpg','','','', 
  200);





  ('Custom1', 'category5',"Good quality at good price", 
  'custom1.jpg','','','', 
  200);






  ('Lapis Lazuli', 'category3',"A deep blue stone with gold flecks, 
  Lapis Lazuli is known for its connection
   to wisdom and truth. It's often used to promote mental
    clarity and self-awareness.", 
  'lapis-lazuli1.jpg','lapis-lazuli2.jpg','lapis-lazuli3.jpeg','lapis-lazuli4.jpeg', 
  200),
  ('Turquoise', 'category4',"A bright blue stone that represents protection and strength. 
  Turquoise is said to bring good fortune, peace, and harmony.", 
  'turquoise1.jpg','turquoise2.jpg','turquoise3.jpeg','turquoise4.jpeg', 
  200);





--  Added 

--  amethyst
  ('Amethyst', 'category1','A deep purple gemstone known for
   its calming energy. Amethyst is often associated with promoting 
   clarity, spiritual growth, and emotional balance.', 
  'amethyst1.jpg','amethyst2.jpg','amethyst3.jpeg','amethyst4.jpeg', 
  200),
--   rose quartz
  ('Rose Quartz', 'category2',"The soft pink hue of Rose 
  Quartz symbolizes love and compassion. It's believed to enhance 
  emotional healing and strengthen relationships.", 
  'rose-quartz1.jpeg','rose-quartz2.jpeg','rose-quartz3.jpeg','rose-quartz4.jpeg', 
  250);