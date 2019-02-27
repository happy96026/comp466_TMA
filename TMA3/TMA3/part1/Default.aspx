<%@ Page Title="" Language="C#" MasterPageFile="~/part1/Site1.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="TMA3.part1.WebForm1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="content">
        Number of Hits:
        <asp:Label ID="Hits" runat="server" Text=""></asp:Label>
        <br />
        IP Address:
        <asp:Label ID="IPAddress" runat="server" Text=""></asp:Label>
        <br />
        Time Zone:
        <asp:Label ID="TimeZone" runat="server" Text=""></asp:Label>
    </div>
</asp:Content>
