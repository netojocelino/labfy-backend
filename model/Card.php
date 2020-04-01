<?php namespace App\Model;


class Card
{
    private $table = "cards";
    private $primary = "card_id";


    /*
    
	[ ] $router->get('/', "CardController@list");
	[ ] $router->delete('/{id}', "CardController@done");
	[ ] $router->post('/', "CardController@new");
	[ ] $router->put('/{id}/move', "CardController@move");
    
    */

    
    public function insert($params = array()) {
        $bind = $this->binder($params);

        $query = "INSERT INTO `$this->table` ($bind->columns) VALUES ($bind->stringColumns)";

        
        $statements = $this->connection->prepare(
            $query
        );

        return json_encode($statements->execute($bind->bind));
    }

    public function select($fields = "*", $conditions = array()) {
        
        $query = "SELECT $fields FROM `$this->table`";
        
        if(isset($conditions['where'])){
            $wheres = implode(" and ", $conditions['where']);
            $query .= "WHERE ($wheres)";
        }
        
        $statements = $this->connection->prepare(
            $query
        ) or die("erro em statements");

        $result = $statements->fetch();
        return($result);
    }

    public function update($params, $conditions = array()) {
        return;
        $bind = $this->binder($conditions);
        $query = "UPDATE `$this->table` SET $bind->";
        
        if(isset($conditions['where'])){
            $wheres = implode(" and ", $conditions['where']);
            $query .= "WHERE ($wheres)";
        }
        
        $statements = $this->connection->prepare(
            $query
        ) or die("erro em statements");

        $result = $statements->fetch();
        return($result);
    }

    public function done($conditions = array()) {
        return $this->update($this->table, [ 'list_state' => 'FRIDGE' ], $conditions);
    }

}

?>