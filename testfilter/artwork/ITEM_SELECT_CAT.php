ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
   $items       = $this->dbConnect($sql);
   $data = array();
   while( $rows = $items->fetch(PDO::FETCH_OBJ)) {
     $data = $rows;
   }
   echo json_encode($data);
}
