<?xml version="1.0"?>
<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:part1="http://localhost:8000/part1">

    <xsl:output method="html" doctype-system="about:legacy-compat"/>
    <xsl:template match="/">
        <html>
            <xsl:apply-templates/>
        </html>
    </xsl:template>

    <xsl:template match="part1:resume">
        <head>
            <meta charset="utf-8"/>
            <title>
                <xsl:value-of select="generalInfo/name/first"/>&#160;<xsl:value-of select="generalInfo/name/last"/>'s Resume
            </title>
            <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="../shared/style.css"/>
        </head>
        <body>
            <div class="wrapper resume">
                <div class="header">
                    <xsl:apply-templates select="generalInfo"/>
                </div>
                <div class="content">
                    <xsl:apply-templates select="educationalBackground"/>
                    <xsl:apply-templates select="workExperience"/>
                </div>
            </div>
        </body>
	</xsl:template>

	<xsl:template match="generalInfo">
        <div class="generalInfo">
            <div id="name"><xsl:value-of select="name"/></div>
            <div><xsl:value-of select="phoneNumber"/></div>
            <div><xsl:value-of select="email"/></div>
            <div><xsl:value-of select="address"/></div>
            <div><xsl:value-of select="website"/></div>
        </div>
	</xsl:template>

	<xsl:template match="educationalBackground">
        <xsl:for-each select="education">
            <div><xsl:value-of select="institution"/></div>
            <div><xsl:apply-templates select="location"/></div>
            <div><xsl:value-of select="degree"/></div>
            <div><xsl:apply-templates select="duration"/></div>
        </xsl:for-each>
	</xsl:template>

	<xsl:template match="workExperience">
        <xsl:for-each select="work">
            <xsl:value-of select="name"/>
            <div><xsl:apply-templates select="location"/></div>
            <div><xsl:value-of select="position"/></div>
            <div><xsl:apply-templates select="duration"/></div>
            <div><xsl:apply-templates select="description"/></div>
        </xsl:for-each>
	</xsl:template>

    <xsl:template match="location">
        <div><xsl:value-of select="start"/></div>
        <div><xsl:value-of select="end"/></div>
    </xsl:template>

    <xsl:template match="duration">
        <div><xsl:value-of select="start"/></div>
        <div><xsl:value-of select="end"/></div>
    </xsl:template>

    <xsl:template match="description">
        <xsl:for-each select="point">
            <div><xsl:value-of select="."/></div>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
