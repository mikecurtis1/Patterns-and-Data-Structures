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
            <link rel="stylesheet" type="text/css" href="ead.css"/>
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

</xsl:stylesheet>
