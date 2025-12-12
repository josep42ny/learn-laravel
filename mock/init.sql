create or replace database myapp character set utf8mb4 collate utf8mb4_general_ci;
use myapp;

create table User (
  id int unsigned auto_increment primary key,
  email varchar(255) not null unique,
  username varchar(255) not null unique,
  picture varchar(255),
  password varchar(255) not null
);

create table Note (
  id int unsigned auto_increment primary key,
  title varchar(255) not null,
  body varchar(255) not null default '',
  userId int unsigned not null,
  constraint fk_note_user foreign key (userId) references User(id)
  on delete cascade on update cascade
);

create table Token (
  value varchar(255) primary key,
  userId int unsigned not null,
  expiration int unsigned not null,
  constraint fk_token_user foreign key (userId) references User(id)
  on delete cascade on update cascade
);

insert into User (email, username, password) values
('bob@example.com', 'Bob' ,'$2a$12$G4KP32KMdLbY2q6603mlLODdYAxVRrRk/nW/rKFIT9x/lj4NiWhVC'),
('alice@example.com', 'Alice' ,'$2a$12$Dcq0fRbdUinOTpkYJV4BpeCGakkUPIKqbIqE5gvmXfVBg.uK3LfHm');

insert into Note (userId, title, body) values
(1, 'Ideas for next vacation', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(2, 'Next art project research', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(1, 'Work reminders', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(2, 'Design techniques blog post', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.'),
(1, 'My skills', 'Asperiores et voluptas qui temporibus. Aperiam dolor similique et et vel voluptatem molestiae illo. Enim sed maxime repudiandae officia voluptatibus deleniti. Aut voluptatem provident et sed earum laudantium tempore.');