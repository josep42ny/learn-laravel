<?php

namespace Core;

enum HttpResponse: int
{
  // 
  case OK = 200;

    //
  case BAD_REQUEST = 400;
  case UNAUTHORIZED = 401;
  case FORBIDDEN = 403;
  case NOT_FOUND = 404;
}
