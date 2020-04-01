<?php namespace App\Controller;

use App\Model;
use \PDO;
use \Exception;

class CardController //extends Model\Card
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
                'mysql:host=localhost;dbname=labfy',
                'labfy',
                'Labfy$'
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
    
        [ ] $router->get('/', "CardController@list");
        [ ] $router->delete('/{id}', "CardController@done");
        [ ] $router->post('/', "CardController@new");
        [ ] $router->put('/{id}/move', "CardController@move");
    
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

            $query = "SELECT $fields FROM `$this->table`";
            
            if(isset($conditions['where'])){
                $wheres = implode(" and ", $conditions['where']);
                $query .= "WHERE ($wheres)";
            }
            
            $statements = $con->prepare($query) or die("erro em statements");

            $statements->execute();


            $result = $statements->fetchAll(PDO::FETCH_ASSOC);
            
            return json_encode($result);
        }catch (Exception $er){
            return json_encode([
                'error' => $er->getMessage()
            ]);

        }
    }

    // public function delete($id) {
    //     return parent::update([
    //         'card_id' => $id
    //     ]);
    // }

    // public function post($dados) {
        
    //     // $bind = $this->binder($params);

    //     $query = "INSERT INTO `$this->table` ($bind->columns) VALUES ($bind->stringColumns)";

        
    //     $statements = $this->connection->prepare(
    //         $query
    //     );

    //     json_encode($statements->execute($bind->bind));
    // }

    public function put($id) {
        $new_state = array(
            'TODO' => 'DOING',
            'DOING' => 'DONE',
            'DONE'  => false,
            'FRIDGE' => 'TODO'
        );
        $card = $this->get(['list_state'], [
                'where' => [
                    "card_id = $id"
                ]
            ]);

            echo $card;

    }

}

?>