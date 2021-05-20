<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_penjualan extends CI_Model {
	
	var $table = 'penjualan';
	var $column_order = array(null,null,'nama_barang'); //file table
	var $column_search = array('nama_barang'); //pencarian yg d ijinkan
	var $order = array('id_penjualan' => 'desc'); // default order
	
	function get_datatables() {
		$this->_get_datatables_query();
		if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
    }
	}
	
	private function _get_datatables_query() {
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0) {
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i){
					$this->db->group_end(); //close bracket
        }
			}
			$i++;
		}
		
		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	function get_data_laba() {
		$this->_get_data_laba_query();
		if($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
    }
	}
	
	private function _get_data_laba_query() {
		$this->db->from($this->table);
		$this->db->join('barang', 'barang.id = penjualan.kode_barang');
		$i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0) {
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i){
					$this->db->group_end(); //close bracket
        }
			}
			$i++;
		}
		
		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
}