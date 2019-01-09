<?php
class Recipe
{
    private $conn;
    protected $id;
    protected $category_id;
    protected $category_name;
    protected $title;
    protected $description;
    protected $serving;
    protected $author;
    protected $created_at;
    protected $ingredients;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //getter
    public function getId(){return $this->id;}
    public function getCategoryId(){return $this->category_id;}
    public function getCategoryName(){return $this->category_name;}
    public function getTitle(){return $this->title;}
    public function getAuthor(){return $this->author;}
    public function getDescription(){return $this->description;}
    public function getServing(){return $this->serving;}
    public function getCreatedAt(){return $this->created_at;}
    public function getIngredients(){return $this->ingredients;}

    //setter
    public function setId($id)
    {
        $id_secure = htmlspecialchars(strip_tags($id));
        $this->id = $id_secure;
    }

    public function setCategoryName($category_name)
    {
        $category_name_secure = htmlspecialchars(strip_tags($category_name));
        $this->category_name = $category_name_secure;
    }

    public function setCategoryId($category_id)
    {
        $category_id_secure = htmlspecialchars(strip_tags($category_id));
        $this->category_id = $category_id_secure;
    }

    public function setTitle($title)
    {
        $title_secure = htmlspecialchars(strip_tags($title));
        $this->title = $title_secure;
    }

    public function setAuthor($author)
    {
        $author_secure = htmlspecialchars(strip_tags($author));
        $this->author = $author_secure;
    }

    public function setDescription($description)
    {
        $description_secure = htmlspecialchars(strip_tags($description));
        $this->description = $description_secure;
    }

    public function setServing($serving)
    {
        $serving_secure = htmlspecialchars(strip_tags($serving));
        $this->serving = $serving_secure;
    }

    public function setCreatedAt()
    {
        $now = date("Y-m-d H:i:s");
        $this->created_at = $now;
    }

    public function setIngredients($ingredients)
    {

        foreach ($ingredients as $ingredient) {
            $ingredient['name'] = htmlspecialchars(strip_tags($ingredient['name']));
            $ingredient['quantity'] = htmlspecialchars(strip_tags($ingredient['quantity']));
            $ingredient['unity'] = htmlspecialchars(strip_tags($ingredient['unity']));
        }
        $this->ingredients = $ingredients;
    }

    public function reformatAndSetIngredients($name, $quantity, $unity){
        $name = explode( ',', $name );
        $quantity = explode( ',', $quantity );
        $unity = explode( ',', $unity );
        $ingredients = [];
        $length = count($name);

        for ($i=0; $i < $length ; $i++) {
            $ingredient[$i] = array(
                "name"  => $name[$i],
                "quantity" => $quantity[$i],
                "unity" => $unity[$i],
            );
            array_push($ingredients, $ingredient[$i]);
        }
        $this->ingredients = $ingredients;
    }


    //GET ALL RECIPES
    public function read()
    {
        $query = 'SELECT c.name AS category_name,
            r.id,
            r.category_id,
            r.title,
            r.description,
            r.author,
            r.created_at
        FROM
            recipes r
        LEFT JOIN
            categories c ON r.category_id = c.id
        ORDER BY
            r.created_at DESC';

        $q = $this->conn->prepare($query);
        $q->execute();
        return $q;
    }


    //GET ALL RECIPES BY CATEGORY
    public function read_by_category()
    {
        $query = 'SELECT c.name AS category_name,
            r.id,
            r.category_id,
            r.title,
            r.description,
            r.author,
            r.created_at
        FROM
            recipes r
        LEFT JOIN
            categories c ON r.category_id = c.id
        WHERE
            r.category_id = ?
        ORDER BY
            r.created_at DESC';

        $q = $this->conn->prepare($query);
        $q->bindParam(1, $this->category_id);
        $q->execute();

        return $q;
    }


    //GET ONE RECIPE
    public function read_single()
    {
        $query = 'SELECT
            C.name AS category_name,
            R.id,
            R.category_id,
            R.title,
            R.description,
            R.serving,
            R.author,
            R.created_at,
            R.serving,
            GROUP_CONCAT(I.unity) AS unity,
            GROUP_CONCAT(I.name) AS name,
            GROUP_CONCAT(I.quantity) AS quantity
        FROM
            recipes R
        LEFT JOIN
            categories C ON R.category_id = C.id
        LEFT JOIN
            recipe_ingredients I ON i.recipe_id = R.id
        WHERE R.id = ?
        GROUP BY R.id';

        $q = $this->conn->prepare($query);
        $q->bindParam(1, $this->id);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);

        $this->setCategoryId($row['category_id']);
        $this->setCategoryName($row['category_name']);
        $this->setDescription($row['description']);
        $this->setServing($row['serving']);
        $this->setTitle($row['title']);
        $this->setAuthor($row['author']);
        $this->setCreatedAt($row['created_at']);
        $this->reformatAndSetIngredients($row['name'], $row['quantity'], $row['unity']);

        if(!$row) {
            return false;
        } else {
            return true;
        }
    }

    //CREATE RECIPE
    public function create()
    {
        $query = 'INSERT INTO recipes
        SET
        title = :title,
        description = :description,
        serving = :serving,
        author = :author,
        category_id = :category_id,
        created_at = :created_at';

        $q = $this->conn->prepare($query);

        $title = $this->getTitle();
        $description = $this->getDescription();
        $serving = $this->getServing();
        $author = $this->getAuthor();
        $category_id = $this->getCategoryId();
        $created_at = $this->getCreatedAt();

        $q->bindParam(':title', $title);
        $q->bindParam(':description', $description);
        $q->bindParam(':serving', $serving);
        $q->bindParam(':author', $author);
        $q->bindParam(':category_id', $category_id);
        $q->bindParam(':created_at', $created_at);

        if($q->execute()){
            //Get recipe id
            $id = $this->conn->lastInsertId();
            $this->setId($id);
            $ingredients = $this->getIngredients();

            //insert recipe's ingredients
            foreach ($ingredients as $ingredient) {
                $query = 'INSERT INTO recipe_ingredients
                SET
                name = :name,
                quantity = :quantity,
                unity = :unity,
                recipe_id = :recipe_id';

                $q = $this->conn->prepare($query);

                $name = $ingredient['product'];
                $quantity = $ingredient['quantity'];
                $unity = $ingredient['unity'];
                $recipe_id = $id;

                $q->bindParam(':name', $name);
                $q->bindParam(':quantity', $quantity);
                $q->bindParam(':unity', $unity);
                $q->bindParam(':recipe_id', $recipe_id);
                $q->execute();
            }
            return true;
        } else {
            printf('Error : %s.\n', $q->error);
            return false;
        }
    }

    // UPDATE RECIPE
    public function update()
    {

        //check if recipe exist
        $query = 'SELECT id FROM recipes WHERE id = ?';
        $q = $this->conn->prepare($query);
        $q->bindParam(1, $this->id);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if(!$row) {return false;}

        //update recipe
        $query = 'UPDATE recipes
        SET
            title = :title,
            description = :description,
            author = :author,
            category_id = :category_id,
            serving = :serving
        WHERE id = :id';

        $q = $this->conn->prepare($query);

        $title = $this->getTitle();
        $description = $this->getDescription();
        $serving = $this->getServing();
        $author = $this->getAuthor();
        $category_id = $this->getCategoryId();
        $id = $this->getId();
        $ingredients = $this->getIngredients();

        $q->bindParam(':title', $title);
        $q->bindParam(':description', $description);
        $q->bindParam(':serving', $serving);
        $q->bindParam(':author', $author);
        $q->bindParam(':category_id', $category_id);
        $q->bindParam(':id', $id);

        if($q->execute()){
            //first delete all previous ingredients
            $query = 'DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id ';
            $q = $this->conn->prepare($query);
            $q->bindParam(':recipe_id', $id);
            $q->execute();

            //then insert new ingredients
            foreach ($ingredients as $ingredient) {
                $query = 'INSERT INTO recipe_ingredients
                SET
                name = :name,
                quantity = :quantity,
                unity = :unity,
                recipe_id = :recipe_id';

                $q = $this->conn->prepare($query);

                $name = $ingredient['name'];
                $quantity = $ingredient['quantity'];
                $unity = $ingredient['unity'];
                $recipe_id = $id;

                $q->bindParam(':name', $name);
                $q->bindParam(':quantity', $quantity);
                $q->bindParam(':unity', $unity);
                $q->bindParam(':recipe_id', $recipe_id);

                $q->execute();
            }
            return true;
        } else {
            printf('Error : %s.\n', $q->error);
            return false;
        }
    }

    //delete a recipe
    public function delete()
    {
        //check if recipe exist
        $query = 'SELECT id FROM recipes WHERE id = ?';
        $q = $this->conn->prepare($query);
        $q->bindParam(1, $this->id);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if(!$row) {return false;}

        //delete recipe
        $query = 'DELETE FROM recipes WHERE id = :id';
        $q = $this->conn->prepare($query);
        $q->bindParam(':id', $this->getId());

        if($q->execute()){
            return true;
        } else {
            printf('Error : %s.\n', $q->error);
            return false;
        }
    }
}
