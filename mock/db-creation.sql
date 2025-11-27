create or replace database myapp character set utf8mb4 collate utf8mb4_general_ci;
use myapp;

create table User (
  id int unsigned auto_increment primary key,
  email varchar(255) not null unique,
  password varchar(255) not null
);

create table Note (
  id int unsigned auto_increment primary key,
  title varchar(255) not null,
  body varchar(255) not null default '',
  userId int unsigned not null,
  constraint fk_Note_User foreign key (userId) references User(id)
  on delete cascade on update cascade
);

insert into User (email, password) values
('bob@example.com', '$2a$12$G4KP32KMdLbY2q6603mlLODdYAxVRrRk/nW/rKFIT9x/lj4NiWhVC'),
('alice@example.com', '$2a$12$Dcq0fRbdUinOTpkYJV4BpeCGakkUPIKqbIqE5gvmXfVBg.uK3LfHm');

insert into Note (userId, title, body) values
(1, 'Ideas for next vacation', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(2, 'Next art project research', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(1, 'Work reminders', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(2, 'Design techniques blog post', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(1, 'My skills', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.');