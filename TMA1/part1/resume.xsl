<?xml version="1.0"?>
<!--TODO: Compare xsl to xsd rather than xml-->
<!--TODO: Include position of job-->
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
                <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"/>-->
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
                <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
                <link rel="stylesheet" type="text/css" href="../shared/styles.css"/>
            </head>
            <body>
                <div class="wrapper resume">
                    <div class="wrapper header">
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
            <div id="resumeName">
                <xsl:value-of select="name"/>
            </div>
            <xsl:apply-templates select="phoneNumber"/> 
            <xsl:apply-templates select="email"/> 
            <xsl:apply-templates select="address"/> 
        </div>
    </xsl:template>

    <xsl:template match="email">
        <div>
            <i class="material-icons">email</i>
            <p>&#160;<xsl:value-of select="."/></p>
        </div>
    </xsl:template>
        
    <xsl:template match="address">
        <div>
            <i class="material-icons">home</i>
            <p>&#160;<xsl:value-of select="number"/> -
                <xsl:value-of select="street"/>,
                <xsl:value-of select="city"/>&#160;<xsl:value-of select="province"/>,
                <xsl:value-of select="postalCode"/>
            </p>
        </div>
    </xsl:template>

    <xsl:template match="phoneNumber">
        <xsl:for-each select=".">
            <div>
                <xsl:if test="type='home'">
                    <i class="material-icons">phone</i>
                </xsl:if>
                <xsl:if test="type='cell'">
                    <i class="material-icons">smartphone</i>
                </xsl:if>
                <xsl:if test="type='work'">
                    <i class="material-icons">work</i>
                </xsl:if>
                <p>&#160;<xsl:value-of select="number"/></p>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="educationalBackground">
        <div class="educationalBackground">
            <h1>Education</h1>
            <xsl:apply-templates select="education"/>
        </div>
    </xsl:template>

    <xsl:template match="education">
        <xsl:for-each select=".">
            <div class="education">
                <div style="float: left;">
                    <xsl:apply-templates select="institution"/>, 
                    <xsl:apply-templates select="location"/>
                </div>
                <div style="float: right;">
                    <xsl:apply-templates select="duration"/>
                </div>
                <div style="clear: both;">
                    <xsl:value-of select="degree"/>
                </div>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="institution">
        <b><xsl:value-of select="."/></b>
    </xsl:template>

    <xsl:template match="workExperience">
        <div class="workExperience">
            <h1>Work Experience</h1>
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
        <i>
            <xsl:apply-templates select="city"/>, <xsl:apply-templates select="province"/>
        </i>
    </xsl:template>

    <xsl:template match="duration">
        <xsl:value-of select="start"/> - <xsl:apply-templates select="end"/>
    </xsl:template>
</xsl:stylesheet>
