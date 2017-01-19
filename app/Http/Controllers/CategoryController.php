<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\AuthController;
use App\Category;
use Larapi;

class CategoryController extends Controller
{
  public function store(Request $request)
  {
    $user = AuthController::getUser($request);
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    // If user isn't an admin
    if ($user->username !== "zlshames" && $user->username !== "cynical89") {
      return Larapi::forbidden();
    }

    // Create Category
    $category = new Category;
    $category->name = $request->name;
    $category->save();

    return Larapi::created();
  }

  public function show(Request $request, $id)
  {
    if ($id == "all") {
      $categories = Category::all();
      return Larapi::ok($categories);
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category");
    }

    return Larapi::ok($category->name);
  }

  public function update(Request $request, $id)
  {
    $user = AuthController::getUser($request);

    // If user isn't logged in
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    // If user isn't an admin
    if ($user->username !== "zlshames" && $user->username !== "cynical89") {
      return Larapi::forbidden();
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category");
    }

    $category->name = $request->name;
    $cateogry->save();

    return Larapi::accepted();
  }

  public function destroy(Request $request, $id)
  {
    $user = AuthController::getUser($request);

    // If user isn't logged in
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    // If user isn't an admin
    if ($user->username !== "zlshames" && $user->username !== "cynical89") {
      return Larapi::forbidden();
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category");
    }

    $category->delete();

    return Larapi::noContent();
  }
}
