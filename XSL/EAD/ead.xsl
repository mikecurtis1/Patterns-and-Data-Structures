<?xml version="1.0"?>
<xsl:stylesheet 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  version="1.0">
<xsl:output method="html"/>

<xsl:template match="text()|@*">
    <xsl:apply-templates/>
</xsl:template>

<xsl:template match="ead">
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <link rel="stylesheet" type="text/css" href="ead.css" media="screen"/>
            <link 
                rel="stylesheet" 
                type="text/css" 
                href="http://fonts.googleapis.com/css?family=Raleway" />
        </head>
        <body>
            <h1>EAD</h1>
            <xsl:apply-templates/>
        </body>
    </html>
</xsl:template>

<xsl:template match="//eadheader">
    <div class="ead_header">
    <xsl:choose>
    <xsl:when test="//eadheader[@relatedencoding='DC']">
        <xsl:for-each select=".//*[@encodinganalog]">
            <div class="dc">
                <label><xsl:value-of select="name(.)"/> (<xsl:value-of select="./@encodinganalog"/>):</label>
                <xsl:value-of select="."/>
            </div>
        </xsl:for-each>
    </xsl:when>
    <xsl:otherwise>
        <div class="no_analog">
            <label>title:</label>
            <xsl:value-of select="//titlestmt/titleproper"/>
            <xsl:if test="//titlestmt/subtitle">
                 - <xsl:value-of select="//titlestmt/subtitle"/>
            </xsl:if>
        </div>
        <xsl:if test="//titlestmt/author">
            <div class="no_analog">
                <label>author:</label>
                <xsl:value-of select="//titlestmt/author"/>
            </div>
        </xsl:if>
        <xsl:if test="//profiledesc/creation">
            <div class="no_analog">
                <label>creation:</label>
                <xsl:value-of select="//profiledesc/creation"/>
            </div>
        </xsl:if>
        <xsl:if test="//profiledesc/langusage">
            <div class="no_analog">
                <label>langusage:</label>
                <xsl:value-of select="//profiledesc/langusage"/>
            </div>
        </xsl:if>
    </xsl:otherwise>
    </xsl:choose>
    </div>
</xsl:template>

<xsl:template match="archdesc">
    <div class="archive_description">
    <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="*[substring(name(),1,2)='c0']|*[substring(name(),1,2)='c1']">
    <div class="c">
    <div><xsl:value-of select="name(.)"/>:<xsl:value-of select="./@level"/></div>
    <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//descgrp">
    <div class="descgrp">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//did">
    <div class="did">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//dsc/head">
    <div class="dsc_head">
        <xsl:value-of select="."/>
    </div>
</xsl:template>

<xsl:template match="//descgrp/*">
    <div class="element">
        <label><xsl:value-of select="name(.)"/>:</label>
        <xsl:value-of select="."/>
    </div>
</xsl:template>

<xsl:template match="//did/*">
    <div class="element">
        <label>
            <xsl:value-of select="name(.)"/>
            <xsl:if test="name(.)='container'">
                <xsl:value-of select="concat(' (', ./@type, ') ')"/>
            </xsl:if>
            :
        </label>
        <xsl:value-of select="."/>
    </div>
</xsl:template>

<xsl:template match="//controlaccess">
    <div class="controlaccess">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//controlaccess/*[substring(name(),1)!='controlaccess']">
    <div class="element">
        <xsl:if test="name(.)!='head'">
            <label><xsl:value-of select="name(.)"/>:</label>
        </xsl:if>
        <xsl:value-of select="."/>
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//scopecontent">
    <div class="scopecontent">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//scopecontent/*[substring(name(),1)!='scopecontent']">
    <div class="element">
        <xsl:if test="name(.)!='head'">
            <label><xsl:value-of select="name(.)"/>:</label>
        </xsl:if>
        <xsl:value-of select="."/>
    </div>
</xsl:template>

<xsl:template match="//bioghist">
    <div class="bioghist">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//bioghist/*[substring(name(),1)!='bioghist']">
    <div>
        <xsl:choose>
            <xsl:when test="name(.)='head'">
                <xsl:attribute name="class">head</xsl:attribute>
            </xsl:when>
            <xsl:otherwise>
                <xsl:attribute name="class">element</xsl:attribute>
            </xsl:otherwise>
        </xsl:choose>
        <xsl:if test="name(.)!='chronlist'">
            <xsl:value-of select="."/>
        </xsl:if>
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//chronitem">
    <div class="chronitem">
        <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="//chronitem/*">
    <div>
        <xsl:attribute name="class">
            <xsl:value-of select="name(.)"/>
        </xsl:attribute>
        <xsl:value-of select="."/>
    </div>
</xsl:template>

</xsl:stylesheet>
