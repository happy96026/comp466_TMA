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
            <xsl:apply-templates select="name"/> 
            <div id="resume-position">
                <xsl:value-of select="position"/>
            </div>
            <xsl:apply-templates select="phoneNumber"/> 
            <xsl:apply-templates select="email"/> 
            <xsl:apply-templates select="address"/> 
            <xsl:apply-templates select="website"/> 
        </div>
    </xsl:template>

    <xsl:template match="generalInfo/name">
        <div id="resume-name">
            <xsl:value-of select="first"/>&#160;<xsl:value-of select="last"/>
        </div>
    </xsl:template>

    <xsl:template match="phoneNumber">
        <xsl:for-each select=".">
            <div class="info">
                <xsl:if test="type='home'">
                    <i class="material-icons">phone</i>
                </xsl:if>
                <xsl:if test="type='cell'">
                    <i class="material-icons">smartphone</i>
                </xsl:if>
                <xsl:if test="type='work'">
                    <i class="material-icons">business</i>
                </xsl:if>
                <div>&#160;<xsl:value-of select="number"/></div>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="email">
        <div class="info">
            <i class="material-icons">email</i>
            <div class="inline">&#160;<xsl:value-of select="."/></div>
        </div>
    </xsl:template>

    <xsl:template match="address">
        <div class="info">
            <i class="material-icons">home</i>
            <div>&#160;<xsl:if test="apartment">
                    <xsl:value-of select="apartment"/> - 
                </xsl:if>
                <xsl:value-of select="number"/>&#160;<xsl:value-of select="street"/>,
                <xsl:value-of select="city"/>&#160;<xsl:value-of select="province"/>,
                <xsl:value-of select="postalCode"/>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="website">
        <div class="info">
            <i class="material-icons">public</i>
            <div>&#160;<xsl:value-of select="."/></div>
        </div>
    </xsl:template>

    <xsl:template match="educationalBackground">
        <div class="category">
            <h1>Education</h1>
            <xsl:apply-templates select="education"/>
        </div>
    </xsl:template>

    <xsl:template match="education">
        <xsl:for-each select=".">
            <div class="highlight">
                <div style="float: left;">
                    <div><xsl:apply-templates select="institution"/></div>
                    <div><xsl:value-of select="degree"/></div>
                </div>
                <div style="float: right; text-align: right;">
                    <div><xsl:apply-templates select="location"/></div>
                    <div><xsl:apply-templates select="period"/></div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="institution | work/name">
        <b><xsl:value-of select="."/></b>
    </xsl:template>

    <xsl:template match="workExperience">
        <div class="category">
            <h1>Work Experience</h1>
            <xsl:apply-templates select="work"/>
        </div>
    </xsl:template>

    <xsl:template match="work">
        <xsl:for-each select=".">
            <div class="highlight">
                <div style="float: left;">
                    <div><xsl:apply-templates select="name"/></div>
                    <div><xsl:apply-templates select="position"/></div>
                </div>
                <div style="float: right; text-align: right;">
                    <div><xsl:apply-templates select="location"/></div>
                    <div><xsl:apply-templates select="period"/></div>
                </div>
                <div style="clear: both;"></div>
                <xsl:apply-templates select="description"/>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="company | name">
        <div>
            <xsl:value-of select="."/>
        </div>
    </xsl:template>

    <xsl:template match="description">
        <ul>
            <xsl:for-each select="point">
                <li><xsl:value-of select="."/></li>
            </xsl:for-each>
        </ul>
    </xsl:template>

    <xsl:template match="location">
        <i>
            <xsl:apply-templates select="city"/>, <xsl:apply-templates select="province"/>
        </i>
    </xsl:template>

    <xsl:template match="period">
        <xsl:apply-templates select="start"/> - <xsl:apply-templates select="end"/>
    </xsl:template>

    <xsl:template match="start | end">
        <i>
            <xsl:value-of select="month"/>&#160;<xsl:value-of select="year"/>
        </i>
    </xsl:template>
</xsl:stylesheet>
