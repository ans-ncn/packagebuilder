```bash
ddev start
ddev composer install
ddev exec touch public/FIRST_INSTALL
ddev launch typo3/install.php
ddev composer config -- scripts.typo3-cms-scripts 'typo3cms install:fixfolderstructure' 'typo3cms database:updateschema' && sed -i 's/typo3cms", "/typo3cms /g' composer.json
```