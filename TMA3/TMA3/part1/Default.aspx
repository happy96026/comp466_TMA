<%@ Page Title="Tracker" Language="C#" MasterPageFile="~/part1/Layout.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="TMA3.part1.Default" %>
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
    <asp:GridView ID="GridView1" runat="server" OnSelectedIndexChanged="GridView1_SelectedIndexChanged">
    </asp:GridView>
</asp:Content>
