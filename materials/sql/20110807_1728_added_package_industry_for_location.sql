alter table `locations`
   add column `package` enum('starter','pro') NULL after `billing_type`,
   add column `industry` enum('automotive','hospitality','restaurant') NULL after `package`