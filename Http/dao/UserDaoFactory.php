<?php

namespace Http\dao;

class UserDaoFactory
{
  public static function assemble(): UserDao
  {
    return new UserDaoDbImpl();
  }
}
