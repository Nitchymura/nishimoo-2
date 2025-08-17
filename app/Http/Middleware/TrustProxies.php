<?php

protected $proxies = '*'; // または Heroku のプロキシ範囲
protected $headers = \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL;

?>