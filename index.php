<?php

$books = [
  [
    "name" => "Do Androids Dream of Electric Sheep?",
    "author" => "Philip K. Dick",
    "releaseYear" => 1968,
    "purchaseUrl" => "https://example.com/androids-dream"
  ],
  [
    "name" => "Project Hail Mary",
    "author" => "Andy Weir",
    "releaseYear" => 2021,
    "purchaseUrl" => "https://example.com/hail-mary"
  ],
  [
    "name" => "The Martian",
    "author" => "Andy Weir",
    "releaseYear" => 2011,
    "purchaseUrl" => "https://example.com/hail-mary"
  ],
];

$filteredBooks = array_filter($books, fn($book) => $book['releaseYear'] > 2000);

require "index.view.php";
