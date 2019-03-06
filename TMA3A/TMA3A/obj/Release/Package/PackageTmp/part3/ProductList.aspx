<%@ Page Title="" Language="C#" MasterPageFile="~/part3/Layout.Master" AutoEventWireup="true" CodeBehind="ProductList.aspx.cs" Inherits="TMA3.part3.ProductList" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<div class="common-breadcrumb border-box">
		<a href="Default.aspx">Home</a>
		<span> / </span>
		<a href="Category.aspx">Category</a>
		<span> / </span>
		<asp:Label ID="ComputerCategory" runat="server" Text="Desktop"/>
	</div>
	<asp:ScriptManager EnablePartialRendering="true" ID="ScriptManager1" runat="server"></asp:ScriptManager>
	<asp:UpdatePanel ID="UpdatePanel1" runat="server">
		<ContentTemplate>
			<div class="container" id="product-list">
				<aside class="side">
					<div class="side-container border-box">
						<div class="checkbox">
							<span class="label">Label</span>
							<asp:CheckBoxList ID="ComputerLabel" runat="server" CssClass="checkbox-content" OnSelectedIndexChanged="Label_Change" AutoPostBack="true">
							</asp:CheckBoxList>
						</div>
						<div class="checkbox">
							<span class="label">Brand</span>
							<asp:CheckBoxList ID="ComputerBrand" runat="server" CssClass="checkbox-content" OnSelectedIndexChanged="Brand_Change" AutoPostBack="true">
							</asp:CheckBoxList>
						</div>
					</div>
				</aside>
				<div class="no-side">
					<div class="item-list">
						<asp:ListView ID="ComputerList" runat="server" DataKeyNames="ComputerID" ItemType="TMA3.part3.Models.Computer" SelectMethod="GetComputers">
							<ItemTemplate>
								<a class="item button" href="Product.aspx?productID=<%#:Item.ComputerID %>">
									<img src="<%#:Item.ImagePath %>"/>
									<div class="item-info">
										<span class="brand"><%#:Item.Brand %></span>
										<span class="name"><%#:Item.Name %></span>
										<span class="price"><%#:Item.GetPriceStr() %></span>
									</div>
								</a>
							</ItemTemplate>
						</asp:ListView>
					</div>
				</div>
			</div>
		</ContentTemplate>
	</asp:UpdatePanel>
</asp:Content>
