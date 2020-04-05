<?php namespace App\Controller;

$dev = true;
define("DB_HOST", "127.0.0.1");
define("DB_NAME", $dev ? "labfy" : "id12906066_labfy");
define("DB_USER", $dev ? "labfy" : "id12906066_labfy");
define("DB_PASSWORD", $dev ? "Labfy$" : "@000.(&LabFy)");

require_once "model/Card.php";

use App\Model;
use \PDO;
use \Exception;

class CardController
{
    private $table = "cards";
    private $primary = "card_id";
    private $connection = null;
    private $isConnected = false;
    private $errorConnection = null;

    public function instance(){
        if($this->connection != null) return $this->connection;
        try{
            $this->connection = new \PDO(
                "mysql:host=". DB_HOST .";dbname=" . DB_NAME,
                DB_USER,
                DB_PASSWORD
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            if($this->connection) {
                $this->isConnected = true;
            }else {
                $this->isConnected = false;
            }

            return $this->connection;

        }catch(PDOException $error){
            $errorConnection = $error->getMessage();
            echo json_encode(["PDOError: " => $error->getMessage()]);
        }
        catch(Exception $e) {
            $errorConnection = $e->getMessage();
            echo json_encode([ "Generic Error" => $e->getMessage() ]);
        }finally{
            if( $this->isConnected == null ) {
                $this->isConnected = false;
                throw new Exception("Erro ao conectar ao banco.");
            }
        }
    }

    protected function connection() {
        return $this->isConnected;
    }

    /*
    
        [X] $router->get('/', "CardController@list");
        [X] $router->delete('/{id}', "CardController@done");
        [X] $router->post('/', "CardController@new");
        [X] $router->put('/{id}/move', "CardController@move");
    
    */

    public function get($fields = "*", $conditions = array()) {
        try{

            $con = $this->instance();
            if(! $this->isConnected ) {
                $msg = json_encode([
                    'error' => "Connection failured",
                    'message' => $this->errorConnection
                ]);
                echo $msg;
                return $msg;
            }

            $query = "SELECT $fields FROM `$this->table` ";
            
            if(isset($conditions['where'])){
                $wheres = implode(" and ", $conditions['where']);
                $query .= " WHERE ($wheres) ";
            }
            if(isset($conditions['order'])){
                $order_by =$conditions['order'];
                $query .= " ORDER BY $order_by ";
            }
            
            $statements = $con->prepare($query) or die("erro em statements");

            $statements->execute();


            $result = $statements->fetchAll(PDO::FETCH_ASSOC);
            $list_result = array();
            foreach ($result as $value) {
                $card = new Model\Card([
                    "card_id" => $value["card_id"],
                    "title" => $value["title"],
                    "list_state" => $value["list_state"],
                    "content" => $value["content"],
                    "label" => $value["label"],
                    "created_by" => $value["created_by"],
                ]);
                $list_result[] = $card->metadata();
            }
            
            return json_encode($list_result);

        }catch (Exception $er){
            return json_encode([
                'error' => $er->getMessage()
            ]);

        }
    }

    public function delete($id) {
        return $this->put($id, true);
    }

    public function post($dados) {

        $dados = (array)$dados;
        $dados = (array)json_decode(json_decode(json_encode($dados))[0]);
        $card = new Model\Card($dados);

        $response = array(
            "status" => 200
        );

        try {
            $query = "INSERT INTO `$this->table` (
                    `title`,
                    `list_state`,
                    `content`,
                    `label`,
                    `created_by`
                )
                VALUES (
                    '" . $dados['title'] ."',
                    'TODO',
                    '" . $dados['content'] ."',
                    '" . $dados['label'] ."',
                    '" . $dados['created_by'] ."'
                )";

            $con = $this->instance();

            if(! $this->isConnected ) {
                $msg = json_encode([
                    'error' => "Connection failured",
                    'message' => $this->errorConnection
                ]);
                $response["code"] = 500;
                $response["mesage"] = $msg;
            }

            $con->exec($query);
     
            $card = json_decode($this->get("*", [ "order" => "card_id DESC" ]))[0];
            return json_encode($card);
        }catch(Exception $e){
            return json_encode([
                'error' => $er->getMessage()
            ]);

        }

    }

    public function put($id, $fridge = false) {
        $new_state = array(
            '"TODO"' => '"DOING"',
            '"DOING"' => '"DONE"',
            '"DONE"'  => '"DONE"',
            '"FRIDGE"' => '"TODO"',
        );
        $card = json_decode($this->get('card_id, list_state', [ 'where' => [ "card_id = $id" ] ]))[0];
        $msg = [];
        
        $list_state = $new_state[json_encode($card->list_state)];
        if($fridge == true){
            $list_state = '"FRIDGE"';
        }
        
        $query = "UPDATE `$this->table` SET list_state = $list_state WHERE card_id = $id";

        $con = $this->instance();
        if(! $this->isConnected ) {
            $msg = [
                'error' => "Connection failured",
                'message' => $this->errorConnection
            ];
            return json_encode($msg);
        }

        try{

            $con->exec($query);
            
            
            $card->list_state = str_replace("\"", "", $list_state);
            $msg = $card;

        }catch(\Exception $e){
            $msg = [
                'error' => $er->getMessage()
            ];
            }
            
            return json_encode($msg);
        }

}

?>