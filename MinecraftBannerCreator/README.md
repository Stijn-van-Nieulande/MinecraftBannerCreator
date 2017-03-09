# Minecraft Banner Creator

###### Usage Example:

```
require "MinecraftBannerCreator.php";

$MCBC = new MinecraftBannerCreator();

$MCBC->setBaseColor("GRAY");
$MCBC->addPattern("WHITE",		"STRIPE_BOTTOM");
$MCBC->addPattern("WHITE",		"STRIPE_TOP");
$MCBC->addPattern("LIGHT_BLUE",	"RHOMBUS_MIDDLE");
$MCBC->addPattern("WHITE",		"STRIPE_DOWNRIGHT");
$MCBC->addPattern("GRAY",		"BORDER");
$MCBC->addPattern("BLACK",		"CURLY_BORDER");
$MCBC->create();
```
