<?php
  include("db_connect.php");
  $request_method = $_SERVER["REQUEST_METHOD"];

  function getTodo($id=0)
  {
    global $conn;
    $query = "SELECT * FROM todo";
    if($id != 0)
    {
      $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);
    $response = mysqli_fetch_row($result);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

  function getTodos()
  {
    global $conn;
    $query = "SELECT * FROM todo";
    $response = array();
    $result = mysqli_query($conn, $query);
    $response = mysqli_fetch_all($result);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

  function AddTodo()
  {
    global $conn;
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO todo(titre, description, modified) VALUES('".$titre."', '".$description."', '".$modified."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Todo added with success'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'ERROR!.'. mysqli_error($conn)
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function updateTodo($id)
  {
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);
    $titre = $_PUT["titre"];
    $description = $_PUT["description"];
    $modified = date('Y-m-d H:i:s');
    //create SQL request
    $query="UPDATE todo SET titre='".$titre."', description='".$description."', modified='".$modified."' WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Todo update with success.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Todo update failed. '. mysqli_error($conn)
      );
      
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function deleteTodo($id)
  {
    global $conn;
    $query = "DELETE FROM todo WHERE id=".$id;
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Todo delete with success.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Todo delete failed. '. mysqli_error($conn)
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  switch($request_method)
  {
    case 'GET':
      // Retrive Todos
      if(!empty($_GET["id"]))
      {
        $id = intval($_GET["id"]);
        getTodos($id);
      }
      else
      {
        getTodos();
      }
      break;

    case 'POST':
      // Add a Todo
      AddTodo();
      break;
    
    case 'PUT':
      // Edit Todo
      $id = intval($_GET["id"]);
      updateTodo($id);
      break;

    case 'DELETE':
      // Delete a Todo
      $id = intval($_GET["id"]);
      deleteTodo($id);
      break;

    default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }
?>