<?xml version="1.0"?>
<xsl:stylesheet 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:mets="http://www.loc.gov/METS/" 
  xmlns:mods="http://www.loc.gov/mods/v3" 
  xmlns:upstate="http://www.example.net/upstate" 
  xmlns:xlink="http://www.w3.org/1999/xlink"
  version="1.0">
<xsl:output method="html"/>

<!-- override the default template match. see: http://stackoverflow.com/a/3378562/4223423 & http://www.w3.org/TR/xslt#built-in-rule -->
<xsl:template match="text()|@*">
  <xsl:apply-templates/>
</xsl:template>

<xsl:template match="/">
  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="upstate.css" media="screen" />
    </head>
    <body>
      <h1>Sample METS record</h1>
      <xsl:apply-templates/>
    </body>
  </html>
</xsl:template>

<xsl:template match="//mets:mdWrap[@MDTYPE='DC']/mets:xmlData">
  <div class="dc">
    <xsl:for-each select="./*">
      <xsl:value-of select="name(.)"/><br />
      <xsl:value-of select="."/>
      <hr />
    </xsl:for-each>
  </div>
</xsl:template>

<xsl:template match="//mets:mdWrap[@MDTYPE='MODS']/mets:xmlData">
  <div class="mods">
    <!--<xsl:for-each select="./*">-->
    <xsl:for-each select=".//mods:subject">
      <xsl:value-of select="name(.)"/><br />
      <xsl:value-of select="./@authority"/><br />
      <xsl:value-of select="."/>
      <hr />
    </xsl:for-each>
  </div>
</xsl:template>

<xsl:template match="//mets:mdWrap[@MDTYPE='OTHER']/mets:xmlData/upstate:object">
  <div class="upstate_object">
    <xsl:for-each select="./*">
      <xsl:value-of select="name(.)"/><br />
      <xsl:value-of select="."/>
      <hr />
    </xsl:for-each>
  </div>
</xsl:template>

<xsl:template match="//mets:amdSec/mets:techMD/mets:mdWrap[@MDTYPE='OTHER']/mets:xmlData/upstate:image">
  <div class="upstate_image">
    <xsl:for-each select="./*">
      <xsl:value-of select="name(.)"/><br />
      <xsl:value-of select="."/>
      <hr />
    </xsl:for-each>
  </div>
</xsl:template>

<xsl:template match="//mets:fileSec">
  <div class="file_sec">
    <xsl:for-each select="./mets:fileGrp">
      <xsl:value-of select="./mets:file/@MIMETYPE"/><br />
      <xsl:value-of select="./mets:file/mets:FLocat/@xlink:href"/><br />
      <xsl:value-of select="./mets:file/mets:FLocat/@xlink:role" />
      <hr />
    </xsl:for-each>
  </div>
</xsl:template>

</xsl:stylesheet>