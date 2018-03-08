<?php
class Kas extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('kas_model');
                $this->load->helper('url_helper');
        }

        public function index()
        {
            $data['kas'] = $this->kas_model->get_kas();
            $data['title'] = 'Posisi Kas';
    
            $this->load->view('templates/header', $data);
            $this->load->view('kas/kas', $data);
            $this->load->view('templates/footer');
        }

        public function view(){

        }

        public function kode(){
            $data['kas'] = $this->kas_model->get_kode_kas();
            $data['title'] = 'Kode Kas';

            $this->load->view('templates/header', $data);
            $this->load->view('kas/kode', $data);
            $this->load->view('templates/footer');
        }

        public function totalkas(){
            $data['title'] = 'Total Kas';

            $month = $this->uri->segment(3);
            $year = $this->uri->segment(4);

            if(empty($month)){
                $month = date('m');
                $year = date('Y');
            }

            if(empty($year)){
                $year = date('Y');
            }
            
            $data['kas'] = $this->kas_model->get_kas_with_kode_by_month($month,$year);

            $penerimaan = 0;
            $pengeluaran = 0;


            foreach($data["kas"] as $kasItem){
                if($kasItem["status"] == 1){
                    $penerimaan = $penerimaan + $kasItem["nilai"];
                }else{
                    $pengeluaran = $pengeluaran + $kasItem["nilai"];
                }
            }
            $data["penerimaan"] = $penerimaan;
            $data["pengeluaran"] = $pengeluaran;
            $data["selisih"] = $penerimaan - $pengeluaran;

            $this->load->view('templates/header', $data);
            $this->load->view('kas/totalkas', $data);
            $this->load->view('templates/footer');
        }

        /** API AREA */

        public function createKas(){
            $no = $_POST["no"];
            $kode = $_POST["kode"];
            $ket = $_POST["ket"];
            $status = $_POST["status"];
            $type = $_POST["type"];
            $nilai = $_POST["nilai"];
            $tanggal = $_POST["tanggal"];
            
            $kas = 0;
            $bank = 0;

            $responseCheck = "0";
            $responseInfo = "";
            $responseId = "";

            /// Cek apakah ada kodenya
            $responseCheck = $this->kas_model->check_kode_kas($kode);
            
            
            if($responseCheck == "1"){

                if($type == "1"){
                    $kas = $nilai;
                }else{
                    $bank = $nilai;
                }

                $insert_data = $this->kas_model->create_kas(
                    $no,
                    $kode,
                    $ket,
                    $status,
                    $kas,
                    $bank,
                    $tanggal);

                if($insert_data["status"] == "1"){
                    $responseId = $insert_data["id"];
                    $responseInfo = "Berhasil menambahkan kas";
                }else{
                    $responseCheck = 0;
                    $responseInfo = "Gagal, pastikan data terisi";
                }
            }else if($responseCheck == "2"){
                $responseCheck = "0";
                $responseInfo = "Gagal, cek apakah kode sudah terisi";
            }else{
                $responseInfo = "Gagal, kode tidak ditemukan";
            }

            $response = array(
                "status" => $responseCheck,
                "id" => $responseId,
                "info" => $responseInfo
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function getKas(){
            $id = $_POST["id"];

            $kode = $this->kas_model->get_kas($id);

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($kode, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function getKasLastMonth(){
            $month = date('m');
            $year = date('Y');
            $kas = $this->kas_model->get_kas_by_month($month,$year);
            $saldo = $this->kas_model->get_last_saldo();
            
            $pengeluaran = 0;
            $penerimaan = 0;
            $saldoKas = 0;
            $saldoBank = 0;

            foreach($kas as $kasItem){
                if($kasItem["status"] == 1){
                    $penerimaan = $penerimaan + $kasItem["kas"];
                    $penerimaan = $penerimaan + $kasItem["bank"];
                }else{
                    $pengeluaran = $pengeluaran + $kasItem["bank"];
                    $pengeluaran = $pengeluaran + $kasItem["kas"];
                }
            }

            foreach($saldo as $saldoItem){
                if($saldoItem["status"] == 1){
                    $saldoKas = $saldoKas + $saldoItem["kas"];
                    $saldoBank = $saldoBank + $saldoItem["bank"];
                }else{
                    $saldoKas = $saldoKas - $saldoItem["kas"];
                    $saldoBank = $saldoBank - $saldoItem["bank"];
                }
            }

            $response = array(
                "penerimaan" => $penerimaan,
                "pengeluaran" => $pengeluaran,
                "kas" => $saldoKas,
                "bank"=> $saldoBank
            );
            
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function getKasWithKodeByMonth(){
            $month = "01";
            $year = date('Y');
            $kas = $this->kas_model->get_kas_with_kode_by_month($month,$year);
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($kas, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function getTotalKasByMonth(){
            $month = $_POST["month"];
            $year = $_POST["year"];

            if(empty($month)){
                $month = date('m');
                $year = date('Y');
            }

            if(empty($year)){
                $year = date('Y');
            }

            $kas = $this->kas_model->get_kas_with_kode_by_month($month,$year);
            $penerimaan = 0;
            $pengeluaran = 0;


            foreach($kas as $kasItem){
                if($kasItem["status"] == 1){
                    $penerimaan = $penerimaan + $kasItem["nilai"];
                }else{
                    $pengeluaran = $pengeluaran + $kasItem["nilai"];
                }
            }

            $selisih = $penerimaan - $pengeluaran;

            $response = array(
                "kas"=>$kas,
                "penerimaan"=>$penerimaan,
                "pengeluaran"=>$pengeluaran,
                "selisih"=>$selisih
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function editKas(){
            $id = $_POST["id"];
            $no = $_POST["no"];
            $kode = $_POST["kode"];
            $ket = $_POST["ket"];
            $status = $_POST["status"];
            $type = $_POST["type"];
            $nilai = $_POST["nilai"];
            $tanggal = $_POST["tanggal"];
            
            $kas = 0;
            $bank = 0;

            $responseCheck = "0";
            $responseInfo = "";

            $responseCheck = $this->kas_model->check_kode_kas($kode);
            
            
            if($responseCheck == "1"){

                if($type == "1"){
                    $kas = $nilai;
                }else{
                    $bank = $nilai;
                }

                $insert_data = $this->kas_model->edit_kas(
                    $id,
                    $no,
                    $kode,
                    $ket,
                    $status,
                    $kas,
                    $bank,
                    $tanggal);

                if($insert_data == "1"){
                    $responseInfo = "Berhasil menambahkan kas";
                }else{
                    $responseCheck = 0;
                    $responseInfo = "Gagal, pastikan data terisi";
                }
            }else if($responseCheck == "2"){
                $responseCheck = "0";
                $responseInfo = "Gagal, cek apakah kode sudah terisi";
            }else{
                $responseInfo = "Gagal, kode tidak ditemukan";
            }

            $response = array(
                "status" => $responseCheck,
                "info" => $responseInfo
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function deleteKas(){
            $id = $_POST["id"];

            $status = $this->kas_model->delete_kas($id);

            $responseInfo = '';
            if($status == '1'){
                $responseInfo = "Berhasil menghapus kas";
            }else{
                $responseInfo = "Gagal menghapus kas";
            }

            $response = array(
                "status" => $status,
                "info" => $responseInfo
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function getKode(){
            $kode = $this->kas_model->get_kode_kas();

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($kode, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function createKode(){
            $id = $_POST["id"];
            $nama = $_POST["nama"];

            $status = $this->kas_model->create_kode_kas($id,$nama);
            $info = "";

            if($status === "0"){
                $info = "Gagal, cek apakah ada data yang kosong";
            }else if($status === "1"){
                $info = "Penambahan kode berhasil";
            }else{
                $info = "Gagal, sudah ada kode dengan id yang sama";
            }

            $response = array(
                "status" => $status,
                "info" => $info
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function editKode(){
            $id = $_POST["id"];
            $newID = $_POST["newId"];
            $nama = $_POST["nama"];

            $status = $this->kas_model->edit_kode_kas($id,$newID,$nama);
            $info = "";

            if($status === "0"){
                $info = "Gagal, cek apakah ada data yang kosong";
            }else if($status === "1"){
                $info = "Perubahan kode berhasil";
            }else{
                $info = "Gagal, sudah ada kode dengan id yang sama";
            }

            $response = array(
                "status" => $status,
                "info" => $info
            );

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        public function deleteKode(){
            $id = $_POST["id"];

            $status = $this->kas_model->delete_kode_kas($id);
            $info = "";

            if($status === "0"){
                $info = "Gagal, cek apakah ada data yang kosong";
            }else{
                $info = "Berhasil menghapus kode";
            }

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
            exit;
        }

        /*
        public function view($slug = NULL)
        {
                $data['news_item'] = $this->news_model->get_news($slug);

                if (empty($data['news_item']))
                {
                        show_404();
                }

                $data['title'] = $data['news_item']['title'];

                $this->load->view('templates/header', $data);
                $this->load->view('news/view', $data);
                $this->load->view('templates/footer');
        }*/

        
}

?>