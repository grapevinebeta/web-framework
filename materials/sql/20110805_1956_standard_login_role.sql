-- login role
INSERT INTO `roles` (`id`, `name`, `description`) VALUES (NULL, 'login', 'standard role for users able to login');

-- assign login role to the first user
-- TODO: it is only for development purposes, this should be assigned during the registration
INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES ((SELECT `id` FROM `users` LIMIT 1), (SELECT `id` FROM `roles` WHERE `name`='login' LIMIT 1));