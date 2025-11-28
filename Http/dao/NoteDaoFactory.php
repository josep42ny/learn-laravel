<?php

namespace Http\dao;

class NoteDaoFactory
{
  public static function assemble(): NoteDao
  {
    return new NoteDaoDbImpl();
  }
}
