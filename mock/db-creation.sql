drop database if exists myapp;
create database myapp;
use myapp;

create table posts (
  id int unsigned not null auto_increment primary key,
  title varchar(255) not null
  );

insert into posts(title) values 
('My first blog post'),
('My second blog post');