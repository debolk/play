<?php

class FrontController extends BaseController
{
  /**
   * Serve the main interface
   * @return void
   */
  public function index()
  {
    return View::make('index');
  }
}
