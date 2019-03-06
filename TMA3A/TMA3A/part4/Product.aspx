<%@ Page Title="" Language="C#" MasterPageFile="~/part3/Layout.Master" AutoEventWireup="true" CodeBehind="Product.aspx.cs" Inherits="TMA3.part4.Product" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<div class="common-breadcrumb border-box">
		<a href="Default.aspx">Home</a>
		<span> / </span>
		<a href="Category.aspx">Category</a>
		<span> / </span>
		<asp:HyperLink runat="server" ID="ProductListLink"/>
	</div>
	<asp:ScriptManager EnablePartialRendering="true" ID="ScriptManager1" runat="server"></asp:ScriptManager>
	<asp:UpdatePanel ID="UpdatePanel1" runat="server">
		<ContentTemplate>
			<div class="container" id="product">
				<div class="no-side">
					<div class="detail border-box">
						<div>
							<asp:Image runat="server" ID="ProductImage"/>
						</div>
						<div class="info">
							<div>
								<div class="brand-name border-box">
									<asp:Label runat="server" ClientIDMode="Static" ID="BrandLabel"/>
									<asp:Label runat="server" ClientIDMode="Static" ID="NameLabel" />
								</div>
								<div class="parts border-box">
									<span>CPU:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="CpuDropDown">
									</asp:DropDownList>

									<span>RAM:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="RamDropDown">
									</asp:DropDownList>

									<span>Hard Drive:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="HardDriveDropDown">
									</asp:DropDownList>

									<span>Display:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="DisplayDropDown">
									</asp:DropDownList>

									<span>Operating System:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="OsDropDown">
									</asp:DropDownList>

									<span>Quantity:</span>
									<asp:DropDownList runat="server" AutoPostBack="true" OnSelectedIndexChanged="DropDown_Change" ID="QuantityDropDown">
										<asp:ListItem Text="1" Value="1"/>
										<asp:ListItem Text="2" Value="2"/>
										<asp:ListItem Text="3" Value="3"/>
										<asp:ListItem Text="4" Value="4"/>
										<asp:ListItem Text="5 (Max)" Value="5"/>
									</asp:DropDownList>
								</div>
								<div class="price">
									<asp:Label runat="server" ClientIDMode="Static" ID="PriceLabel" />
								</div>

							</div>
							<asp:Button runat="server" ClientIDMode="Static" ID="AddToCart" Text="Add To Cart" CssClass="button" OnClick="AddToCart_Cick"/>
						</div>
					</div>
					<div class="about">
						<span class="label-header">About</span>
					</div>
				</div>
			</div>
		</ContentTemplate>
	</asp:UpdatePanel>
</asp:Content>
