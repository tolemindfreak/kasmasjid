<?php
class Kas_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        /** Kas Zone */

        public function get_kas($id = null)
        {
                if (empty($id))
                {
                        $this->db->select("kas.id,kas.no,kas.kode,kas.ket,kas.status,kas.kas,kas.bank,kas.tanggal,kode.nama as nama");
                        $this->db->from("kas");
                        $this->db->join('kode','kas.kode = kode.id','left');
                        $this->db->order_by("kas.no desc");
                        $query = $this->db->get();
                        return $query->result_array();
                }

                $query = $this->db->get_where('kas', array('id' => $id));
                return $query->row_array();
        }

        public function create_kas(
            $no = null,
            $kode = null,
            $ket = null,
            $status = null,
            $kas = null,
            $bank = null,
            $tanggal = null
        ){

            if(empty($no) || empty($kode) || empty($ket) || empty($status)){
                /// Jika data yang harus dibutuhkan ada yang kosong
               $data = array(
                    "status"=>"0",
                    "id" => "0"
                );
                return $data;
            }else{


                $formattedTanggal = str_replace("/","-",$tanggal);
                $tanggalFormat = new Datetime($formattedTanggal);
                $formattedTanggal = date_format($tanggalFormat, 'Y-m-d');

                $data = array(
                    'no' => $no,
                    'kode' => $kode,
                    'ket' => $ket,
                    'status' => $status,
                    'kas' => $kas,
                    'bank' => $bank,
                    'tanggal' => $formattedTanggal
                );

                $this->db->insert('kas', $data);
                $post_id = $this->db->insert_id();

                $data = array(
                    "status"=>"1",
                    "id" => $post_id
                );

                return $data;
            }
        }

        public function edit_kas(
            $id,
            $no,
            $kode,
            $ket,
            $status,
            $kas,
            $bank,
            $tanggal
        ){
            if(empty($id) || empty($no) || empty($kode) || empty($ket) || empty($status)){
                return '0';
            }else{
                $data = array(
                    'no' => $no,
                    'kode' => $kode,
                    'ket' => $ket,
                    'status' => $status,
                    'kas' => $kas,
                    'bank' => $bank,
                    'tanggal' => $tanggal
                );

                $this->db->where('id',$id);
                $this->db->update('kas',$data);

                return '1';
            }
        }

        public function delete_kas($id){
            if(empty($id)){
                return '0';
            }else{
                $this->db->where('id',$id);
                $this->db->delete('kas');

                return '1';
            }
        }

        public function get_last_saldo(){
            $this->db->select("status,sum(kas) as kas,sum(bank) as bank");
            $this->db->from("kas");
            $this->db->group_by('status'); 
            $query = $this->db->get();
            return $query->result_array();
        }

        public function get_kas_by_year($year){

        }

        public function get_kas_by_month($month,$year){
            if(empty($month) || empty($year)){
                return null;
            }

            $this->db->select("status,sum(kas) as kas,sum(bank) as bank");
            $this->db->from("kas");
            $this->db->where("Month(tanggal) = " . $month);
            $this->db->where("Year(tanggal) = " . $year);
            $this->db->group_by('status'); 
            $query = $this->db->get();
            return $query->result_array();
        }

        public function get_kas_with_kode_by_month($month,$year){
            if(empty($month) || empty($year)){
                return null;
            }

            $this->db->select("kode, kode.nama as nama, status, sum(kas) + sum(bank) as nilai");
            $this->db->from("kas");
            $this->db->where("Month(tanggal) = " . $month);
            $this->db->where("Year(tanggal) = " . $year);
            $this->db->join('kode','kas.kode = kode.id','left');
            $this->db->group_by('status , kode'); 
            $this->db->order_by('status asc');
            $query = $this->db->get();
            return $query->result_array();
        }

        /** Kode Zone */
        /**
             * Get Kode Status --> Check kode availability
             * 2 Kode null
             * 1 Kode available
             * 0 Kode unavailable
             */
        public function check_kode_kas($id = null){
            if($id === false){
                /// Jika kode yang diberikan kosong maka kembalikan nilai 2
                return 2;
            }else{
                $queryCheck = $this->db->get_where('kode',array('id' => $id));
                if(empty($queryCheck->result())){

                    /// Jika masih belum ada kode dengan id tersebut, maka bisa memasukkan kode yang baru

                    return "0";
                }else{

                    /// Jika sudah ada data dengan id yang sama maka kasih kode 2

                    return "1";
                }
            }
        }

        public function get_kode_kas($kode = null)
        {
                if (empty($kode))
                {
                        $query = $this->db->get('kode');
                        return $query->result_array();
                }
        
                $query = $this->db->get_where('kode', array('id' => $kode));
                return $query->row_array();
        }

        public function create_kode_kas($id = null, $nama = null){

            /// Cek apakah id diberikan

            if(empty($id) || empty($nama)){

                /// Jika tidak diberikan id maka kasih kode 0

                return "0";
            }else{

                /// Cek apakah id yang diberikan sudah ada pada database atau belum

                $queryCheck = $this->db->get_where('kode',array('id' => $id));
                
                if(empty($queryCheck->result())){

                    /// Jika masih belum ada kode dengan id tersebut, maka bisa memasukkan kode yang baru

                    $data = array(
                        'id' => $id,
                        'nama' => $nama
                    );

                    $this->db->insert('kode', $data);

                    return "1";
                }else{

                    /// Jika sudah ada data dengan id yang sama maka kasih kode 2

                    return "2";
                
                }
            }
        }

        public function edit_kode_kas($id = null, $newID = null, $nama = null){
            
            /// Cek apakah data yang diberikan ada yang kosong

            if(empty($id) || empty($newID) || empty($nama)){
                
                /// Jika tidak ada data yang diberikan

                return "0";
            }else{
                /// Cek apakah id yang baru sama dengan id yang lama

                if($id == $newID){
                    
                    /// Jika id yang baru sama dengan id yang lama maka hanya akan mengganti nama nya

                    $this->db->set('nama', $nama);
                    $this->db->where('id', $id);
                    $this->db->update('kode');

                    return "1";

                }else{

                    /// Jika id yang baru berbeda dengan id yang lama, maka akan mengganti id dan nama
                    /// Tetapi pertama cek dulu apakah id yang baru sudah ada di database atau belum

                    $queryCheck = $this->db->get_where('kode',array('id' => $newID));
                    if(empty($queryCheck->result())){
                        /// Jika masih belum ada kode dengan id tersebut, maka bisa mengganti data dengan kode yang baru
                        $data = array(
                            'id' => $newID,
                            'nama' => $nama
                        );
                        $this->db->set('id', $newID);
                        $this->db->set('nama', $nama);
                        $this->db->where('id', $id);
                        $this->db->update('kode');

                        return "1";

                    }else{
                        
                        /// Jika sudah ada data dengan id yang sama maka kasih kode 2

                        return "2";
                    }
                }
            }
        }

        public function delete_kode_kas($id = null){

            /// Cek apakah data yang diberika ada yang kosong
            
            if(empty($id)){
                 /// Jika tidak ada data yang diberikan

                 return "0";
            }else{
                $this->db->where('id', $id);
                $this->db->delete('kode');

                return "1";

            }

        }

}

?>