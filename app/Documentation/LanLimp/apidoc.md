1. instalar npm install apidoc -g
2. crear apidoc.json
{
    "name": "LanLimp",
    "version": "1.0.0",
    "description": "",
    "title": "LanLimp documentation",
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

3. cd app/Documentation/LanLimp/
4. apidoc -i app/Documentation/LanLimp -o public/docs/
