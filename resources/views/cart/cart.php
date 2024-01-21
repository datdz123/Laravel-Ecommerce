<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    // session_destroy();
    // die();

    $quantity = (isset($_POST['quantity'])) ? $_POST['quantity'] : 1;

    $product = '';
    $query = getID();
    if($query){
        $product = mysqli_fetch_assoc($query);
    }


    if(isset($_POST['buy-now'])){
        if(isset( $_SESSION['cart'][$id])){ //co san pham thi cong don so luong
            $_SESSION['cart'][$id]['quantity'] += $quantity;
            header('Location: index.php?page=cart');
        }
        else{ //chua co thi tao moi san pham
            $_SESSION['cart'][$id] = [
                'id' => $product['id_sanpham'],
                'name' => $product['tensp'],
                'img' => $product['anhsp'],
                'price' => $product['giasp'],
                'quantity' => $quantity
            ];
            header('Location: index.php?page=cart');
        }

    }   

    if(isset($_POST['add-to-cart'])){

        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity'] += $quantity;
            header('Location: index.php?page=details&id='.$_GET['id'].'');
        }
        else{
            $_SESSION['cart'][$id] = [
                'id' => $product['id_sanpham'],
                'name' => $product['tensp'],
                'img' => $product['anhsp'],
                'price' => $product['giasp'],
                'quantity' => $quantity
            ];
            header('Location: index.php?page=details&id='.$_GET['id'].'');
        }
    }
    

    $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
    
    //tong tien
    function total_price($cart){
        $total_price = 0;
        foreach($cart as $key => $value){
            $total_price += $value['quantity'] * $value['price'];
        }
        return $total_price;
    }

    $rand = rand(10,1000);

    $madh = 'MDH' . $rand;
    $makh = 'MAKH' . $rand;
    $_SESSION['makh'] = $makh;
    $_SESSION['madh'] = $madh;
    

    if(isset($_POST['order'])){
        if(isset($_SESSION['fullname'])){
            $tenkh = $_POST['hoten'];
            $tongtien = total_price($cart);
    
            $diachi = $_POST['sonha'].' '.$_POST['xa'].' '.$_POST['tinh'];
            $sdt = $_POST['sdt'];
            $email = $_SESSION['email'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `khachhang` (`makh`, `tenkh`, `diachi`, `email`, `sdt`) VALUES ('$makh', '$tenkh', '$diachi', '$email', '$sdt')";
            //var_dump($sql);
            $query = mysqli_query($conn, $sql);
    
            $sql2 = "INSERT INTO dathang (madathang, makh, trangthai, tongtien, ngaydathang, id_kh) VALUES ('$madh', '$makh', 'đang xử lý', '$tongtien', '$date', '0') ";
            $query2 = mysqli_query($conn, $sql2);
    
            //yourorder
            //$madathang = $_SESSION['madathang'];
            $id_sanpham = '';
            $tensp = '';
            $soluong = '';
            $giatien = '';

            foreach($cart as $keyID => $valueID){
                $_SESSION['id_sanpham'] = $valueID['id'];
                $id_sanpham = $_SESSION['id_sanpham'];

                $_SESSION['tensp'] = $valueID['name'];
                $tensp = $_SESSION['tensp'];

                $_SESSION['soluong'] = $valueID['quantity'];
                $soluong = $_SESSION['soluong'];

                $_SESSION['giatien'] = $valueID['price'] * $valueID['quantity'];
                $giatien = $_SESSION['giatien'];

                $sql_chitiet_donhang = "INSERT INTO chitiet_donhang (madathang, makh, id_sanpham, tensp, soluong, giatien, tongtien, trangthai, ngaydat, id_dathang, id_kh) 
                VALUES ('$madh', '$makh', '$id_sanpham', '$tensp', '$soluong', '$giatien', '$tongtien', 'đang xử lý', '$date', '0', '0') ";

                $query_chitiet_donhang = mysqli_query($conn, $sql_chitiet_donhang);

                
                unset($_SESSION['cart']);
            }
    
            header("Location: index.php?page=yourorder-details&id=$makh");
        }
        
        else{
            echo "<script>alert('Bạn cần đăng nhập để sử dụng chức năng này');</script>";
        }
    }


    ///chua xu ly luu dc hang vao db voi thanh toan online
    if(isset($_POST['ordervnpay'])){
        
            $tenkh = $_POST['hoten'];
            $_SESSION['hoten'] = $tenkh;
            $tongtien = total_price($cart);
    
            $diachi = $_POST['sonha'].' '.$_POST['xa'].' '.$_POST['tinh'];
            $sdt = $_POST['sdt'];
            $email = $_SESSION['email'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `khachhang` (`makh`, `tenkh`, `diachi`, `email`, `sdt`) VALUES ('$makh', '$tenkh', '$diachi', '$email', '$sdt')";
            //var_dump($sql);
            $query = mysqli_query($conn, $sql);
    
            $sql2 = "INSERT INTO dathang (madathang, makh, trangthai, tongtien, ngaydathang, id_kh) VALUES ('$madh', '$makh', 'đang xử lý', '$tongtien', '$date', '0') ";
            $query2 = mysqli_query($conn, $sql2);
    
            //yourorder
            //$madathang = $_SESSION['madathang'];
            $id_sanpham = '';
            $tensp = '';
            $soluong = '';
            $giatien = '';

            foreach($cart as $keyID => $valueID){
                $_SESSION['id_sanpham'] = $valueID['id'];
                $id_sanpham = $_SESSION['id_sanpham'];

                $_SESSION['tensp'] = $valueID['name'];
                $tensp = $_SESSION['tensp'];

                $_SESSION['soluong'] = $valueID['quantity'];
                $soluong = $_SESSION['soluong'];

                $_SESSION['giatien'] = $valueID['price'] * $valueID['quantity'];
                $giatien = $_SESSION['giatien'];

                $sql_chitiet_donhang = "INSERT INTO chitiet_donhang (madathang, makh, id_sanpham, tensp, soluong, giatien, tongtien, trangthai, ngaydat, id_dathang, id_kh) 
                VALUES ('$madh', '$makh', '$id_sanpham', '$tensp', '$soluong', '$giatien', '$tongtien', 'đang xử lý', '$date', '0', '0') ";

                $query_chitiet_donhang = mysqli_query($conn, $sql_chitiet_donhang);
            }
    
            //header("Location: index.php?page=vnpay_create_payment");
    
    }

?>
<!-- Giohang  -->
    <div class="cart__body">
        <a class="buy_continute" href="index.php"><i class="fa fa-arrow-circle-left"></i> Tiếp tục mua hàng</a>
        
        <form method="POST" action="" id="getinfo_form">
            <div class="row">
                <div class="col-lg-8 cart__items-box">
                    <?php 
                        if(!empty($cart)){
                            foreach($cart as $keyID => $valueID){
                                ?>
                                    <div class="cart__items">
                                        <div class="row">
                                            <div class="col-sm-3 col-5">
                                                <img src="./<?php echo $valueID['img']; ?>" alt="" class="cart__items-img">
                                            </div>
                                            <div class="col-sm-9 col-7">
                                                <h3>
                                                <?php echo $valueID['name']; ?>
                                                </h3>
        
                                                <br>
                                                <div class="cart__items-pride">
                                                    <div class="product__pride-newPride">
                                                        <span class="Price">
                                                            <bdi>
                                                                <?php echo number_format($valueID['price'] * $valueID['quantity']); ?>
                                                                &nbsp;
                                                                <span class="currencySymbol">₫</span>
                                                            </bdi>
                                                        </span>
                                                    </div>
            
                                                    <div class="cart__items-count">
                                                        Số lượng
                                                        <?php echo $valueID['quantity']; ?>
                                                    </div>
                                                
                                                </div>
                                                <a class="delete_cart" href="index.php?page=cartdelete&id=<?php echo $valueID['id']; ?>">Xóa sản phẩm</a>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="update_cart">
                                        <a class="update_cart-del" href="index.php?page=cartdeleteall" onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ sản phẩm?')">
                                            Xóa toàn bộ sản phẩm
                                        </a>
                                        <!-- <button type="submit" class="update_cart-up" name="update_cart-up">
                                            Cập nhập giỏ hàng
                                        </button> -->

                                    </div> 
                            
                                <?php
                                $_SESSION['giasp'] = total_price($cart);
        
                            }
                        }
                        else{
                            ?>
                            <div class="emptyCart">
                                <img src="./img/empty_cart.png" alt="">
                            </div>
                            <?php
                        }

                    ?>  
                    
                    </div>

                <div class="col-lg-4" style="padding-left: 20px; padding-right: 10px;">
                    <div>
                        <div class="cart__info">
                            <div class="body__mainTitle">
                                <h2>ĐỊA CHỈ NHẬN HÀNG</h2>
                            </div>
                            <center>
                                <div class="cart__info-form">
                                    <?php 
                                        if(isset($_SESSION['email'])){
                                            ?>
                                                <input type="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>">
                                                <input type="text" placeholder="Họ và tên" name="hoten" required><br>
                                                <input type="text" placeholder="Số điện thoại" name="sdt" required>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <input type="text" placeholder="Họ và tên"><br>
                                                <input type="email" placeholder="Email">
                                                <input type="text" placeholder="Số điện thoại">
                                            <?php
                                        }
                                    ?>
                                    
                                    

                                    <div class="address">
                                        <h6>Tỉnh / Thành Phố</h6>
                                        <select name="calc_shipping_provinces" required>
                                            <option value="">Tỉnh/Tp</option>
                                        </select>
                                    </div>

                                    <div class="address">
                                        <h6>Quận / Huyện</h6>
                                        <select name="calc_shipping_district" required>
                                            <option value="">Quận/Huyện</option>
                                        </select>
                                    </div>
                                    
                                    <input class="billing_address_1" name="tinh" type="hidden" value="">
                                    <input class="billing_address_2" name="xa" type="hidden" value="">

                                    <div class="address">
                                        <h6>Số nhà: </h6>
                                        <input type="text" name="sonha" id="">
                                    </div>

                                <input type="hidden" Checked="True" id="bankCode" name="bankCode" value="">

                                <input type="hidden" id="language" Checked="True" name="language" value="vn">
                                <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="hidden" value="<?php echo total_price($cart); ?>" />
                        
                                
                            </center>

                            <br>
                            <br>
                            <div class="body__mainTitle">
                                <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                            </div>

                            <div class="phuongthuctt">
                                <input type="radio" id="op1" name="op1" required>
                                <label for="op1">Chuyển khoản</label>

                                <br>

                                <input type="radio" id="op2" name="op1">
                                <label for="op2">Trả tiền khi nhận hàng</label>
                            </div>
                            
                            <div class="total">
                                <h5>Tổng thanh toán</h5>
                                <br>

                                <div class="product__pride-newPride" style="font-size: 25px;">
                                    <span class="Price">
                                        <bdi><?php echo number_format(total_price($cart)); ?>&nbsp;
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                            </div>

                            <center><button class="buy" name="order" id="order" type="submit">Đặt hàng</button></center>
    
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="go-to-top"><i class="fas fa-chevron-up"></i></div>
<!-- Giohang -->

<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script>
    //chuyen khoan
    $('#op1').click(function() {
        $('#order').attr('name', 'ordervnpay');
        $('#getinfo_form').attr('action', '/shopthucung/index.php?page=vnpay_create_payment');
        
    });

    //cod
    $('#op2').click(function() {
        $('#order').attr('name', 'order');
    });
</script>