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
            <link rel="stylesheet" type="text/css" href="generic.css" media="screen"/>
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

<xsl:template match="*">
    <div>
        <xsl:attribute name="class"><xsl:value-of select="name(.)"/></xsl:attribute>
        <!--<xsl:if test="string-length(normalize-space(text()))>0">-->
            <label><xsl:value-of select="name(.)"/>:</label>
            <!--<xsl:value-of select="string-length(normalize-space(text()))"/> : -->
        <!--</xsl:if>-->
        <xsl:value-of select="text()"/>
        <xsl:apply-templates/>
    </div>
</xsl:template>

</xsl:stylesheet>
