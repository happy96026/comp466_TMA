<%@ Page Title="" Language="C#" MasterPageFile="~/part3/Layout.Master" AutoEventWireup="true" CodeBehind="Category.aspx.cs" Inherits="TMA3.part3.Category" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<div class="container">
		<div class="no-side margin-content">
			<span class="label-header">Categories</span>
			<div class="item-list">
				<a href="ProductList.aspx?category=Desktop" class="item button">
					<div>
						<img src="img/Desktop.png">
					</div>
					<span class="item-label">Desktop</span>
				</a>
				<a href="ProductList.aspx?category=Laptop" class="item button">
					<div>
						<img src="img/Laptop.png">
					</div>
					<span class="item-label">Laptop</span>
				</a>
			</div>
		</div>
	</div>
</asp:Content>
