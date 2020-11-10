1. instalar npm install apidoc -g
2. crear apidoc.json
{
    "name": "Docs",
    "version": "1.0.0",
    "description": "",
    "title": "Ecommerce Documentaciòn",
    "url": "https://flowdevs.com/api/v1",
    "header": {
        "title": "Introducciòn",
        "filename": "header.md"
    },
    "footer": {
        "title": "MIT License",
        "filename": "footer.md"
    },
    "order": [
        "Auth",
        "Stores",
        "Products",
        "Shares",
        "Orders"
    ],
    "template": {
        "withCompare": true,
        "withGenerator": true
    }
}

3. cd app/Documentation/LamLimp/
4. apidoc -i app/Http/Controllers -o public/docs/
