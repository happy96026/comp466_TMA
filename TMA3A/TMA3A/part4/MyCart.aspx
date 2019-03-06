<%@ Page Title="" Language="C#" MasterPageFile="~/part4/Layout.Master" AutoEventWireup="true" CodeBehind="MyCart.aspx.cs" Inherits="TMA3.part4.MyCart" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<asp:ScriptManager EnablePartialRendering="true" ID="ScriptManager1" runat="server"></asp:ScriptManager>
	<asp:UpdatePanel ID="UpdatePanel1" runat="server">
		<ContentTemplate>
			<div class="container" id="my-cart">
				<div class="no-side">
					<span class="label-header">My Cart</span>
					<div class="cart-list">
						<span class="cart-item-header"></span>
						<span class="cart-item-header"></span>
						<span class="cart-item-header">Price</span>
						<span class="cart-item-header" id="quantity-header">Quantity</span>
						<asp:ListView ID="CartList" runat="server" DataKeyNames="ComputerID" ItemType="TMA3.part4.Models.Computer" OnItemCommand="OnItemCommand">
							<ItemTemplate>
								<div class="image cart-item">
									<img src="<%#:Item.ImagePath %>"/>
								</div>
								<div class="info cart-item">
									<a href="Product.aspx?productID=<%#:Item.ComputerID %>" id="name"><%#:Item.Brand %> <%#: Item.Name %></a>
									<ul>
										<li ><%#:Item.GetCpu().GetFullName() %></li>
										<li ><%#:Item.GetRam().GetFullName() %></li>
										<li ><%#:Item.GetHardDrive().GetFullName() %></li>
										<li ><%#:Item.GetDisplay().GetFullName() %></li>
										<li ><%#:Item.GetOs().GetFullName() %></li>
									</ul>
								</div>
								<div class="price cart-item">
									<span id="price"><%#:Item.GetUnitPriceStr() %></span>
								</div>
								<div class="edit cart-item">
									<div style="position: relative">
										<asp:DropDownList ID="QuantityDropDown" runat="server" OnSelectedIndexChanged="Quantity_Change" AutoPostBack="true">
											<asp:ListItem Text="1" Value="1" />
											<asp:ListItem Text="2" Value="2"/>
											<asp:ListItem Text="3" Value="3"/>
											<asp:ListItem Text="4" Value="4"/>
											<asp:ListItem Text="5 (Max)" Value="5"/>
										</asp:DropDownList>
										<asp:Button ID="DeleteButton" runat="server" Text="Delete" CssClass="delete" CommandName="Remove"/>
									</div>
								</div>
							</ItemTemplate>
						</asp:ListView>
					</div>
					<div class="checkout-output">
						<div>
							<span>Total: </span>
							<asp:Label runat="server" ID="PriceLabel" Text="$199.99"/>
						</div>
						<div>
							<asp:Button ID="CheckoutButton" runat="server" Text="Checkout" CssClass="button"/>
						</div>
					</div>
				</div>
			</div>
		</ContentTemplate>
	</asp:UpdatePanel>
</asp:Content>
