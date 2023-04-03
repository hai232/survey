  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
      <a href="javascript:void(0)" class="brand-link dropdown-toggle" style = "padding: 13px 25px;" data-toggle="dropdown" aria-expanded="true">
          <img src="/survey/assets/dist/img/Logo.png" class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 38px;height:50px"> 
          <span class="brand-text font-weight-light"><?php echo ucwords($_SESSION['login_ten']) ?></span>
      </a>
        <div class="dropdown-menu" style="">
          <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Thông tin cá nhân</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="ajax.php?action=logout">Đăng xuất</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-treeview" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="index.php?page=home" class="nav-link nav-home" >
              <i class="nav-icon fas fa-tachometer-alt "></i>
              <p>
                Bảng điều khiển
              </p>
            </a>
          </li>    
          <?php if($_SESSION['login_chuc_vu'] == 1): ?>
                <li class="nav-item">
                  <a href="./index.php?page=user_list" class="nav-link nav-edit_user list-group-item-action  ">
                    <i class="nav-icon fas fa-users nav-user_list"></i>
                    <p>
                      Quản Lý tài khoản
                    </p>
                  </a>
                </li>
              <li class="nav-item">
                <a href="./index.php?page=survey_list" class="nav-link nav-is-tree nav-edit_survey nav-view_survey ">
                  <i class="nav-icon fa fa-poll-h"></i>
                  <p>
                  Quản Lý khảo sát
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=survey_report" class="nav-link tree-item">
                  <i class="nav-icon fas fa-poll"></i>
                  <p>
                    Thống kê
                  </p>
                </a>
              </li>     
            <?php else: ?>
              <li class="nav-item">
                <a href="./index.php?page=survey_widget" class="nav-link nav-survey_widget nav-answer_survey">
                  <i class="nav-icon fas fa-poll-h"></i>
                  <p>
                    Danh sách khảo sát
                  </p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="./index.php?page=survey_history" class="nav-link nav-survey_widget nav-answer_survey">
                  <i class="nav-icon fas fa-poll-h"></i>
                  <p>
                    Lịch sử khảo sát
                  </p>
                </a>
              </li>  
          <?php endif; ?>
      </ul>
      </nav>
    </div>
  </aside>
<style>
      ul li:is(:link, :active, :visited).active{
          text-decoration: none;
    }
    li:is(:link, :active, :visited).active{
          background-color: #007bff;
    }
</style>
 <script>
    const activePage = window.location;
    const navLinks = document.querySelectorAll('nav a').forEach(link => {
      if(link.href.includes(`${activePage}`)){
        link.classList.add('active');
      }
      // if(link.href.includes(`index.php?page=new_user`)){
      //   link.classList.add('active');
      // }
      // if(link.href.includes(`index.php?page=new_user`)){
      //   link.classList.add('active');
      // }
    })

</script>
  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'Trang Chủ' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }
  		}
      $('.manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>
