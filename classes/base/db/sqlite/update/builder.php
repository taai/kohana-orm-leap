<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Copyright 2011 Spadefoot
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * This class builds a SQLite update statement.
 *
 * @package Leap
 * @category SQL
 * @version 2011-06-13
 *
 * @see http://www.sqlite.org/lang_update.html
 *
 * @abstract
 */
abstract class Base_DB_SQLite_Update_Builder extends DB_SQL_Update_Builder {

   /**
     * This constructor instantiates this class.
     *
     * @access public
     */
    public function __construct() {
		parent::__construct('SQLite');
	}

	/**
	 * This function returns the SQL statement.
	 *
	 * @access public
	 * @param boolean $terminated           whether to add a semi-colon to the end
	 *                                      of the statement
	 * @return string                       the SQL statement
	 */
	public function statement($terminated = TRUE) {
	    $sql = "UPDATE {$this->data['table']}";
	    
	    if (!empty($this->data['column'])) {
		    $sql .= ' SET ' . implode(', ', array_values($this->data['column']));
	    }
	    
	    if (!empty($this->data['where'])) {
	        $do_append = FALSE;
            $sql .= ' WHERE ';
	        foreach ($this->data['where'] as $where) {
	            if ($do_append && ($where[1] != DB_SQL_Builder::_CLOSING_PARENTHESIS_)) {
	                $sql .= " {$where[0]} ";
	            }
	            $sql .= $where[1];
	            $do_append = ($where[1] != DB_SQL_Builder::_OPENING_PARENTHESIS_);
	        }
	    }
	    
	    if (!empty($this->data['order_by'])) {
	        $sql .= ' ORDER BY ' . implode(', ', $this->data['order_by']);
	    }
	    
	    if ($this->data['limit'] > 0) {
	        $sql .= " LIMIT {$this->data['limit']}";
	    }
	    
	    if ($this->data['offset'] > 0) {
	        $sql .= " OFFSET {$this->data['offset']}";
	    }

        if ($terminated) {
	        $sql .= ';';
        }

	    return $sql;
	}

}
?>