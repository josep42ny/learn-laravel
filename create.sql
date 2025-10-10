create or replace database myapp character set utfmb4 collate utf8mb4_0900_ai_ci;
use myapp;

create table Note (
  id int unsigned auto_increment primary_key,
  body varchar(255) not null,
  userId int unsigned not null,
  constraint fk_Note_User foreign key (userId) references User(id)
  on delete cascade on update cascade
);

create table User (
  id int unsigned auto_increment primary_key,
  firstName varchar(255) not null,
  email varchar(255) not null unique
);

insert into User (firstName, email) values
('John', 'john@example.com'),
('Kate', 'kate@example.com');

insert into Note (userId, body) values
(1, 'Ideas for next vacation'),
(2, 'Next art project research'),
(1, 'Work reminders'),
(2, 'Design techniques blog post');