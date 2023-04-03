<?php
include 'classes\User.php';
Class Admin extends User {
    function themTaiKhoan(User $user){
        $data = "email = '" . $user -> getEmail(). "', mat_khau = '". $user->getMatKhau() . "', 
                 ten = '" . $user -> getTen() . "', dia_chi = '" . $user -> getDiaChi() . "', 
                 chuc_vu = '" . $user -> getChucVu(). "',so_DT = '" . $user -> getSoDT() . "' ";
        $check = $this->db->query("SELECT * FROM nguoi_dung where email ='". $user -> getEmail() . "' ".(!empty($user->getId()) ? " and id != {$user->getId()} " : ''))->num_rows;
        if($check > 0){
            return 2;
            exit;
        }
        if(empty($user->getId())){
            $save = $this->db->query("INSERT INTO nguoi_dung set $data");
        }else{
            $save = $this->db->query("UPDATE nguoi_dung set $data where id = ".$user->getId());
        }

        if($save){
            return 1;
        }
    }

    function suaTaiKhoan(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
                if($k =='password')
                    $v = md5($v);
                if(empty($data)){
                    $data .= " $k='$v' ";
                }else{
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM nguoi_dung where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
        if($check > 0){
            return 2;
            exit;
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO nguoi_dung set $data");
        }else{
            $save = $this->db->query("UPDATE nguoi_dung set $data where id = $id");
        }

        if($save){
            foreach ($_POST as $key => $value) {
                if($key != 'password' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1;
        }
    }
    function xoaTaiKhoan(){
        extract($_POST);
        $delete = $this->db->prepare("DELETE FROM nguoi_dung where id = ? ");
        $delete->bind_param('s',$id);
        $delete->execute();
        if($delete)
            return 1;
    }

    function thongKeNguoiDung() {
        $res = $this->db->query("SELECT * FROM nguoi_dung order by ten asc");
        return $res;
    }
}
