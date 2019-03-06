<%@ Page Title="" Language="C#" MasterPageFile="~/part4/Layout.Master" AutoEventWireup="true" CodeBehind="Register.aspx.cs" Inherits="TMA3.part4.Register" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<div id="login-container">
		<div class="login border-box">
			<div id="username">
				<label for="user">Username</label>
				<asp:TextBox runat="server" ID="Username" />
				<asp:RequiredFieldValidator ID="UsernameValidator" runat="server" ControlToValidate="Username" ErrorMessage="Username cannot be empty." CssClass="error" Display="Dynamic"/>
				<asp:CustomValidator ID="ExistValidator" runat="server" OnServerValidate="UserExists" ErrorMessage="Username already exists." CssClass="error" Display="Dynamic"/>
			</div>
			<div id="emailDiv">
				<label for="user">Email</label>
				<asp:TextBox runat="server" ID="Email" />
				<asp:RequiredFieldValidator ID="EmailValidator" runat="server" ControlToValidate="Email" ErrorMessage="Email cannot be empty." CssClass="error" Display="Dynamic"/>
			</div>
			<div id="password">
				<label for="pass">Password</label>
				<asp:TextBox runat="server" ID="Password" TextMode="Password"/>
				<asp:RequiredFieldValidator ID="PasswordValidator" runat="server" ControlToValidate="Password" ErrorMessage="Password cannot be empty." CssClass="error" Display="Dynamic"/>
			</div>
			<div id="confirm-password">
				<label for="confirm-pass">Confirm Password</label>
				<asp:TextBox runat="server" ID="Confirm" TextMode="Password"/>
				<asp:CustomValidator ID="ConfirmValidator" runat="server" OnServerValidate="ConfirmPassword" ErrorMessage="Two passwords must match." CssClass="error" Display="Dynamic"/>
			</div>
			<asp:Button runat="server" CssClass="button" Text="Sign up" OnClick="Signup_Click" ID="Signup"/>
		</div>
	</div>
</asp:Content>
