<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Category;
use Larapi;
use Validator;

class CategoryController extends Controller
{
  public function store(Request $request)
  {
    $user = AuthController::getUser($request);
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    $validator = Validator::make(
      $request->all(),
      Category::$validation_rules,
      Category::$validation_messages
    );

    if ($validator->fails()) {
      return Larapi::badRequest($validator->messages()->toArray());
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

    // Validate ID
    if (!is_numeric($id)) {
      return Larapi::badRequest("The ID must be numeric.");
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category.");
    }

    return Larapi::ok($category->name);
  }

  public function update(Request $request, $id)
  {
    $user = AuthController::getUser($request);
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    // Validate ID
    if (!is_numeric($id)) {
      return Larapi::badRequest("The ID must be numeric.");
    }

    // Validate update data
    $validator = Validator::make(
      $request->all(),
      Category::$validation_rules,
      Category::$validation_messages
    );

    if ($validator->fails()) {
      return Larapi::badRequest($validator->messages()->toArray());
    }

    // If user isn't an admin
    if ($user->username !== "zlshames" && $user->username !== "cynical89") {
      return Larapi::forbidden();
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category.");
    }

    $category->name = $request->name;
    $cateogry->save();

    return Larapi::accepted();
  }

  public function destroy(Request $request, $id)
  {
    $user = AuthController::getUser($request);
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    // Validate ID
    if (!is_numeric($id)) {
      return Larapi::badRequest("The ID must be numeric.");
    }

    // If user isn't an admin
    if ($user->username !== "zlshames" && $user->username !== "cynical89") {
      return Larapi::forbidden();
    }

    $category = Category::find($id);
    if ($category == NULL) {
      return Larapi::notFound("Failed to find category.");
    }

    $category->delete();

    return Larapi::noContent();
  }
}
