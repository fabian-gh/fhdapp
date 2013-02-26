<?php

	class GradeModel
	{
		private $connection;

		public function __construct()
		{
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
                        
		}

		public function getGrades($course)
		{
                    if(isset($_SESSION["stc_dual"]))
                    {
                        if(isset($_SESSION["stc_teilzeit"]))
                        {
                            
                        $result = $this->connection->query("SELECT graduate
                        FROM studycourses_view
                        WHERE studycourses_view.name = '".$course."' and (time='Teilzeit' or time='Dual')
                        GROUP BY graduate");
			$resultSet = array();
                        
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
                            
                        }
                        else
                        {
                        $result = $this->connection->query("SELECT graduate
                        FROM studycourses_view
                        WHERE studycourses_view.name = '".$course."' and time='Dual'
                        GROUP BY graduate");
			$resultSet = array();
                        
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
                        }

                    }
                    
                    
                    else if(isset($_SESSION["stc_teilzeit"]))
                    {
                        if($_SESSION["stc_dual"]=='Dual')
                        {
                            
                        $result = $this->connection->query("SELECT graduate
                        FROM studycourses_view
                        WHERE studycourses_view.name = '".$course."' and (time='Teilzeit' or time='Dual')
                        GROUP BY graduate");
			$resultSet = array();
                        
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
                            
                        }
                        else
                        {
                        $result = $this->connection->query("SELECT graduate
                        FROM studycourses_view
                        WHERE studycourses_view.name = '".$course."' and time='Teilzeit'
                        GROUP BY graduate");
			$resultSet = array();
                        
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
                        }

                    }
                    
                    else
                    {
			$result = $this->connection->query("SELECT graduate
                        FROM studycourses_view
                        WHERE studycourses_view.name = '".$course."'
                        GROUP BY graduate");
			$resultSet = array();
                        
			while($row = $result->fetch_assoc())
			{
				$resultSet[] = $row;
			}

			return $resultSet;
                    }
		}
	}
	
?>