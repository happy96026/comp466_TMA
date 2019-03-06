<%@ Page Title="Slideshow" Language="C#" MasterPageFile="~/part2/Layout.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="TMA3.part2.Default" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
			<div class="border-box container">
				<asp:Panel runat="server" id="Panel" Width=800 Height=450 CssClass="panel">
					<asp:Image ID="SlideImage" runat="server"/>
				</asp:Panel>
				<asp:Label runat="server" ID="Caption" CssClass="caption" />
			</div>
            <div class="buttons">
				<div class="button-container">
					<asp:Button ID="RandomButton" runat="server" Text="Random" CssClass="button" OnClick="Random_Click"/>
				</div>
				<div class="button-container" id="center">
					<asp:Button ID="PlayButton" runat="server" Text="Stop" CssClass="button" OnClick="Play_Click"/>
				</div>
				<div class="button-container" id="right">
					<asp:Button ID="PrevButton" runat="server" Text="Prev" CssClass="button" OnClick="Prev_Click"/>
					<asp:Button ID="NextButton" runat="server" Text="Next" CssClass="button" OnClick="Next_Click"/>
				</div>
            </div>
			<asp:Timer ID="SlideshowTimer" OnTick="SetNextImage" runat="server" Interval="2000" />
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
