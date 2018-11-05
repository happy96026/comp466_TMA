<?xml version="1.0"?>
<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:part1="http://localhost:8000/part1">

    <xsl:template match="/part1:resume">
        <html>
            <head>
                <meta charset="utf-8"/>
                <title>
                    <xsl:value-of select="generalInfo/name/first"/>&#160;<xsl:value-of select="generalInfo/name/last"/>'s Resume
                </title>
                <!-- Compiled and minified CSS -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"/>
                <link rel="stylesheet" type="text/css" href="../shared/styles.css"/>
            </head>
            <body>
                <div class="wrapper resume">
                    <div class="header card-panel teal lighten-2">
                        <xsl:apply-templates select="generalInfo"/>
                    </div>
                    <div class="content">
                        <xsl:apply-templates select="educationalBackground"/>
                        <xsl:apply-templates select="workExperience"/>
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>

     <xsl:template match="generalInfo">
        <div class="generalInfo">
            <xsl:apply-templates select="name"/>
            <xsl:apply-templates select="phoneNumber"/> 
            <xsl:apply-templates select="email"/>
            <xsl:apply-templates select="address"/>
        </div>
    </xsl:template>

    <xsl:template match="name | email | address">
        <div>
            <xsl:value-of select="."/>
        </div>
    </xsl:template>

    <xsl:template match="phoneNumber">
        <xsl:for-each select=".">
            <div>
                <xsl:value-of select="."/>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="educationalBackground">
        <div class="educationalBackground">
            <xsl:apply-templates select="education"/>
        </div>
    </xsl:template>

    <xsl:template match="education">
        <xsl:for-each select=".">
            <div class="education">
                <xsl:apply-templates select="institution"/>
                <xsl:apply-templates select="location"/>
                <xsl:apply-templates select="duration"/>
                <xsl:apply-templates select="degree"/>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="institution | degree">
        <div>
            <xsl:value-of select="."/>
        </div>
    </xsl:template>

    <xsl:template match="workExperience">
        <div class="workExperience">
            <xsl:apply-templates select="work"/>
        </div>
    </xsl:template>

    <xsl:template match="work">
        <xsl:for-each select=".">
            <div class="work">
                <xsl:apply-templates select="company"/>
                <xsl:apply-templates select="location"/>
                <xsl:apply-templates select="position"/>
                <xsl:apply-templates select="duration"/>
                <xsl:apply-templates select="description"/>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="company | position">
        <div>
            <xsl:value-of select="."/>
        </div>
    </xsl:template>

    <xsl:template match="description">
        <xsl:for-each select="point">
            <div class="point">
                <xsl:value-of select="."/>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="location">
        <div class="city">
            <xsl:apply-templates select="city"/>
        </div>
        <div class="province">
            <xsl:apply-templates select="province"/>
        </div>
    </xsl:template>

    <xsl:template match="duration">
        <div class="start">
            <xsl:apply-templates select="start"/>
        </div>
        <div class="end">
            <xsl:apply-templates select="end"/>
        </div>
    </xsl:template>
</xsl:stylesheet>
