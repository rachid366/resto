INSERT INTO `city` (`name`, `zipcode`) VALUES ('kech', '12');
INSERT INTO `restaurant` (`city_id_id`, `name`, `description`, `created_at`) VALUES ('1', 'restau', 'desc', '2022-03-18');
INSERT INTO `restaurant_picture` (`restaurant_id_id`, `filename`) VALUES ('1', 'pic.png');
INSERT INTO `uer` (`city_id`, `username`, `password`) VALUES ('1', 'rachid', 'rachid');
INSERT INTO `review` (uer_id_id`, `restaurant_id_id`, `message`, `rating`, `created_at`) VALUES ('1', '1', 'aaa', '12', '2022-03-18');
