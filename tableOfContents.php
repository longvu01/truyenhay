<!DOCTYPE html>
<html>
<head>
	<title>Nhà giả kim</title>
	<script src="https://kit.fontawesome.com/141da4893d.js" crossorigin="anonymous"></script>
	<?php 
	include 'style.css'; ?>
	<style type="text/css">
		#div_tong{
			height: 2500px;
		}
		#div_giua_trai{
			width: 70%;
			height: 100%;
			/*background:orange;*/
			float: left;
			margin-top: 10px;
		}
		.thong_tin_truyen{
			width: 100%;
			height: 30%;
			/*background: red;*/
			/*font-family: Arial, cursive, sans-serif;*/
		}
		#div_giua_phai{
			margin-top: 10px;
			width: 30%;
			height: 100%;
			/*background:black;*/
			float: left;
		}
		.truyen_cung_tac_gia{
			width: 100%;
			height: 15%;
			/*background: darkgrey;*/
		}
		.truyen_cung_tac_gia_text{
			width: 100%;
			height: 15%;
			/*background: blue;*/
		}
		.truyen_cung_tac_gia_text>p{
			padding-top: 10px;
			width: 100%;
			height: 25px;
			margin:0;
			font-size: 20px;
			border-bottom: 1px solid grey;
		}
		.tung_truyen_cung_tac_gia{
			width: 100%;
			height: 10%;
			padding-left: 10px;
		}
		.tung_truyen_cung_tac_gia>a{
			text-decoration: none;
			color: #383838;
		}
		.thong_tin{
			width: 45%;
			height: 100%;
			float: left;
			/*background: orange;*/
		}
		.thong_tin_truyen_text{
			width: 100%;
			height: 10%;
		}
		.thong_tin_truyen_text>p{
			width: 200px;
			height: 30px;
			margin: 0;
			/*padding-left: 20px;*/
			padding-top: 20px;
			text-align: left;
			font-size: 20px;
			border-bottom: 1px solid grey;
			/*background: pink;*/
		}
		.anh{
			width: 100%;
			height: 70%;
			/*background: blue;*/
			box-shadow: -5px 5px 10px darkgrey;
		}
		.anh>img{
			width: 326px;
			height: 437px;
		}
		.thong_tin_chi_tiet{
			width: 100%;
			height: 20%;
			/*background:green;*/
			
		}
		.thong_tin_chi_tiet>p{
			padding-top: 10px;
			padding-left: 10px;
			margin: 0;
		}
		.mo_ta{
			width: 55%;
			height: 100%;
			/*background: black;*/
			float: left;
			margin:0;
		}
		.ten_truyen{
			width: 100%;
			height: 20%;
			/*background: grey;*/
			display: flex;
			justify-content: center;
		}
		.ten_truyen>p{
			width: 90%;
			height: 30%;
			margin: 0;
			text-align: center;
			padding-top: 60px;
			/*background:aqua;*/
			font-weight: bold;
			font-size: 25px;
			border-bottom: 1px solid #ff6122;
		}
		.noi_dung_chinh{
			width: 100%;
			height: 80%;
			/*background: pink;*/
		}
		.noi_dung_chinh>p{
			margin: 0;
			color: grey;
			padding: 10px;
		}
		.danh_sach_chuong{
			width: 100%;
			height: 35%;
			/*background: purple;*/
		}
		.danh_sach_chuong_text{
			width: 100%;
			height: 30px;
			/*background-color: blue;*/
			border-bottom: 1px solid darkgrey;
		}
		.danh_sach_chuong_text>p{
			width: 220px;
			height: 30px;
			margin: 0;
			font-size: 20px;
			border-bottom: 1px solid grey;
		}
		a[class="chuong"]{
			text-decoration: none;
			color: #383838;
		}
		.muc_luc{
			width: 100%;
			height: 90%;
			font-size: 18px;
			/*background:yellow;*/
			padding-left: 10px;
		}
		.trang{
			width: 100%;
			height: 6%;
			/*background: green;*/
			display: flex;
			justify-content: center;
		}
		.trang>p{
			width: 60%;
			height: 100%;
			margin: 0;
			padding:0;
			/*background: blue;*/
			text-align: center;
		}
	</style>
</head>
<body>
	<div id="div_tong">
		<?php include 'menu.php';?>
		<div id="div_giua">
			<div class="trai">
				
			</div>
			<div class="giua">
				<div id="div_giua_trai">
					<div class="thong_tin_truyen">
						<div class=thong_tin>
						<div class="thong_tin_truyen_text">
							<p>THÔNG TIN TRUYỆN</p>	
						</div>
						<div class="anh">
							<img src="https://cdn.glitch.me/f46c82e2-3ebb-48c0-9afb-19ea915ff09d%2Ftr1.jpg?v=1639159644112">
						</div>
						<div class="thong_tin_chi_tiet">
							<p>
							<b>Tác giả: </b> Linh Phương <br>
							<b>Thể loại: </b> Ngôn tình <br>
							<b>Trạng thái: </b> Full <br>
							<b>Lượt đọc: </b> 14000 <br>
							</p>
						</div>
						</div>
						<div class="mo_ta">
							<div class="ten_truyen">
								<P>
									NHÀ GIẢ KIM
								</P>
							</div>
							<div class="noi_dung_chinh">
							<p>
								<b>Nội dung chính:</b>
								<br>
								Một hạt bụi có thể lấp biển, một cọng cỏ chém hết mặt trời mặt trăng và ngôi sao, trong nháy mắt ở giữa long trời lỡ đất. Quần hùng cùng nổi lên, vạn tộc mọc lên san sát như rừng, chư thánh tranh bá, loạn khắp đất trời. Hỏi mặt đất bao la, cuộc đời thăng trầm? Một thiếu niên theo trong đất hoang đi ra, tất cả bắt đầu từ nơi này...
							</p>
							</div>
						</div>
					</div>
					<div class="danh_sach_chuong">
						<div class="danh_sach_chuong_text">
							<p>
							DANH SÁCH CHƯƠNG
							</p>
						</div>
						<div class="muc_luc">
							<table width="100%">
								<tr>
									<td>
										<a href="reading.php" class="chuong" target="_blank">
										Chương 1: Đến vương quốc sa mạc
										</a>
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
								<tr>
									<td>
										Chương 1: Đến vương quốc sa mạc
									</td>
									<td>
										Chương 26: Tìm về nhà
									</td>
								</tr>
							</table>
						</div>
						<div class="trang">
							<P>
								<table width="100%">
									<tr>
										<td>1</td>
										<td>2</td>
										<td>3</td>
										<td>4</td>
										<td>5</td>
										<td>6</td>
										<td>>></td>
										<td>cuối >></td>
										<td>chọn trang</td>
									</tr>
								</table>
							</P>
						</div>
					</div>
				<?php include 'comment.php' ?>
				<div id="div_giua_phai">
					<div class="truyen_cung_tac_gia">
						<div class="truyen_cung_tac_gia_text">
							<P>
								TRUYỆN CÙNG TÁC GIẢ
							</P>
						</div>
						<div class="tung_truyen_cung_tac_gia">
							<i class="fas fa-caret-right"></i>
							<a href=""> Thánh Khư</a>
						</div>
						<div class="tung_truyen_cung_tac_gia">
							<i class="fas fa-caret-right"></i>
							<a href=""> Nàng Bạch Tuyết</a>
						</div>
						<div class="tung_truyen_cung_tac_gia">
							<i class="fas fa-caret-right"></i>
							<a href=""> Thánh Khư</a>
						</div>
						<div class="tung_truyen_cung_tac_gia">
							<i class="fas fa-caret-right"></i>
							<a href=""> Thánh Khư</a>
						</div>
						<div class="tung_truyen_cung_tac_gia">
							<i class="fas fa-caret-right"></i>
							<a href=""> Dế Mèn Đi Ăn Cá</a>
						</div>
					</div>
					<?php include "hotNovels.php" ?>
				</div>
			</div>
			<div class="phai">
				
			</div>
		</div>
		<?php include 'footer.php';?>
	</div>
</body>
</html>