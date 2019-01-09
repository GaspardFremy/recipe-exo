<?php
//all route with '/recipe'

//Get all recipes
$this->respond('GET', '/?', function ($request, $response) {

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    $result = $recipe->read();
    $rowCount = $result->rowCount();

    if ($rowCount > 0){
        $recipe_arr = array();
        $recipe_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $recipe_item = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
                'created_at' => $created_at,
            );
            array_push($recipe_arr['data'], $recipe_item);
        }
        return json_encode($recipe_arr);
    } else {
        return json_encode(
            array('message' => 'No recipe found')
        );
    }
});

//Get all recipes by category
$this->respond('GET', '/category/[:category_id]', function ($request, $response, $service) {

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    //get param
    $param = $request->params();
    $category_id = $param[1];

    //validate it
    $service->validateParam('category_id', 'id must be integer')->notAlpha()->isAlnum();

    //set recipe id
    $recipe->setCategoryId($category_id);

    $result = $recipe->read_by_category();
    $rowCount = $result->rowCount();

    if ($rowCount > 0){
        $recipe_arr = array();
        $recipe_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $recipe_item = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
                'created_at' => $created_at,
            );
            array_push($recipe_arr['data'], $recipe_item);
        }
        return json_encode($recipe_arr);
    } else {
        return json_encode(
            array('message' => 'No recipe found')
        );
    }
});


//get one recipe
$this->respond('GET', '/[:id]', function ($request, $response, $service) {

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    //get param
    $param = $request->params();
    $id = $param[1];

    //validate it
    $service->validateParam('id', 'id must be integer')->notAlpha()->isAlnum();

    //set recipe id
    $recipe->setId($id);

    //get Recipe
    if ($recipe->read_single()){
        $recipe_arr = array(
            'id' => $recipe->getId(),
            'title' => $recipe->getTitle(),
            'description' => $recipe->getDescription(),
            'serving' => $recipe->getServing(),
            'author' => $recipe->getAuthor(),
            'category_id' => $recipe->getCategoryId(),
            'category_name' => $recipe->getCategoryName(),
            'created_at' => $recipe->getCreatedAt(),
            'ingredients' => $recipe->getIngredients()

        );
        print_r(json_encode($recipe_arr));
    } else {
        $response->code(404);
        $msg = array('message' => 'No recipe found for this id');
        return json_encode($msg);
    }
});


//create a recipe
$this->respond('POST', '/new', function ($request, $response, $service) {

    //working with axios on client side but not with postman
    $request_body = file_get_contents("php://input");
    $param = json_decode($request_body, true);

    $title = $param['title'];
    $author = $param['author'];
    $serving = $param['serving'];
    $description = $param['description'];
    $category_id = $param['category_id'];
    $ingredients = $param['ingredients'];

    //validate alphanum character and "_" / "-" / ' and spaces
    $service->addValidator('AlphaNumSpace', function ($str) {
        return preg_match('/^[a-z\d\-_\'\s]+$/i', $str);
    });

    // pass param threw validator
    $service->validate($title, 'title length must be between 1 and 50 characters and alphanum')->isLen(1, 50)->isAlphaNumSpace();
    $service->validate($description, 'description length must be between 1 and 1000 characters and alphanum')->isLen(1, 1000)->isAlphaNumSpace();
    $service->validate($author, 'author length must be between 1 and 20 characters and alphanum')->isLen(1, 20)->isAlphaNumSpace();
    $service->validate($category_id, 'category id must be between 1 and 5')->isInt()->isLen(1);
    $service->validate($serving, 'serving must be an integer up to 20')->isInt()->isLen(1, 20);


    foreach ($ingredients as $ingredient) {
        $product = $ingredient['product'];
        $quantity = $ingredient['quantity'];
        $unity = $ingredient['unity'];

        $service->validate($product, 'product name length must be between 1 and 100 characters and alphanum')->isLen(1, 100)->isAlphaNumSpace();
        $service->validate($quantity, 'product quantity must be an integer and can\'t exeed 1000')->isLen(1, 1000)->isInt();
        $service->validate($unity, 'product unity is needed')->isLen(1, 10)->isAlphaNumSpace();
    }

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    //set recipe instance
    $recipe->setTitle($title);
    $recipe->setDescription($description);
    $recipe->setServing($serving);
    $recipe->setAuthor($author);
    $recipe->setCategoryId($category_id);
    $recipe->setCreatedAt();
    $recipe->setIngredients($ingredients);

    if ($recipe->create())
    {
        echo json_encode(array(
            'success' => 'true',
            'id' => $recipe->getId()
        ));
    } else {
        $response->code(404);
        echo json_encode(array('message' => 'err Post not created'));
    }
});


// update a recipe
$this->respond('PUT', '/update', function ($request, $response, $service) {

    //working with axios on client side but not with postman
    $request_body = file_get_contents("php://input");
    $param = json_decode($request_body, true);

    $title = $param['title'];
    $author = $param['author'];
    $serving = $param['serving'];
    $description = $param['description'];
    $category_id = $param['category_id'];
    $id = $param['id'];
    $ingredients = $param['ingredients'];

    //validate alphanum character and "_" / "-" / ' and spaces
    $service->addValidator('AlphaNumSpace', function ($str) {
        return preg_match('/^[a-z\d\-_\'\s]+$/i', $str);
    });

    // pass param threw validator
    $service->validate($title, 'title length must be between 1 and 50 characters and alphanum')->isLen(1, 50)->isAlphaNumSpace();
    $service->validate($description, 'description length must be between 1 and 200 characters and alphanum')->isLen(1, 1000);
    $service->validate($author, 'author length must be between 1 and 20 characters and alphanum')->isLen(1, 20)->isAlphaNumSpace();
    $service->validate($category_id, 'category id must be between 1 and 5')->isInt()->isLen(1);
    $service->validate($id, 'id must be integer')->isInt();
    $service->validate($serving, 'serving must be an integer up to 20')->isInt()->isLen(1, 20);


    foreach ($ingredients as $ingredient) {
        $product = $ingredient['name'];
        $quantity = $ingredient['quantity'];
        $unity = $ingredient['unity'];

        $service->validate($product, 'product name length must be between 1 and 100 characters and alphanum')->isLen(1, 100)->isAlphaNumSpace();
        $service->validate($quantity, 'product quantity must be an integer and can\'t exeed 1000')->isLen(1, 1000)->isInt();
        $service->validate($unity, 'product unity is needed')->isLen(1, 10)->isAlphaNumSpace();
    }

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    //set recipe instance
    $recipe->setId($id);
    $recipe->setTitle($title);
    $recipe->setDescription($description);
    $recipe->setServing($serving);
    $recipe->setAuthor($author);
    $recipe->setCategoryId($category_id);
    $recipe->setIngredients($ingredients);

    if ($recipe->update())
    {
        echo json_encode(array(
            'success' => 'true',
            'id' => $recipe->getId()
        ));
    } else {
        echo json_encode(array('message' => 'err Post not updated'));
    }
});

$this->respond('DELETE', '/delete/[:id]', function ($request, $response, $service) {

    //instantiate DB and recipe
    $database = new Database();
    $db = $database->connect();
    $recipe = new Recipe($db);

    //get param
    $param = $request->params();
    $id = $param[1];

    //validate it
    $service->validateParam('id', 'id must be integer')->notAlpha()->isAlnum();

    //set recipe id
    $recipe->setId($id);

    if ($recipe->delete())
    {        
        echo json_encode(array('message' => 'recipe deleted'));
        return;
    } else {
        $response->code(404);
        echo json_encode(array('message' => 'Recipe does not exist'));
        return;
    }
});
