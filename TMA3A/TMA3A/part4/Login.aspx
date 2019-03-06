<%@ Page Title="" Language="C#" MasterPageFile="~/part4/Layout.Master" AutoEventWireup="true" CodeBehind="Login.aspx.cs" Inherits="TMA3.part4.Login" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
	<div id="login-container">
		<div class="login border-box">
            <div id="username">
                <label for="user">Username</label>
                <asp:TextBox runat="server" ID="Username" />
				<asp:CustomValidator ID="UserValidator" runat="server" OnServerValidate="ValidateUser" ErrorMessage="Username or password is incorrect." CssClass="error" Display="Dynamic"/>
            </div>
            <div id="password">
                <label for="pass">Password</label>
                <asp:TextBox runat="server" ID="Password" TextMode="Password"/>
            </div>
            <asp:Button CssClass="button" Text="Log in" runat="server" ID="LoginButton" OnClick="Login_Click"/>
        </div>
        <div class="login border-box" id="signup">
            Don't have an account? <a href="Register.aspx" style="color: blue;">Sign up</a>
        </div>
	</div>
</asp:Content>
