create or replace database myapp character set utf8mb4 collate utf8mb4_general_ci;
use myapp;

create table User (
  id int unsigned auto_increment primary key,
  firstName varchar(255) not null,
  email varchar(255) not null unique
);

create table Note (
  id int unsigned auto_increment primary key,
  body varchar(255) not null,
  userId int unsigned not null,
  constraint fk_Note_User foreign key (userId) references User(id)
  on delete cascade on update cascade
);

insert into User (firstName, email) values
('John', 'john@example.com'),
('Kate', 'kate@example.com');

insert into Note (userId, body) values
(1, 'Ideas for next vacation'),
(2, 'Next art project research'),
(1, 'Work reminders'),
(2, 'Design techniques blog post');