## Getting Started

### Installation
Add entry in /etc/hosts
```bash
127.0.0.1 stayforlong.test
```
Build images
```bash
make build
```
Run containers
```bash
make up
```
Install packages
```bash 
make install
``` 

## Usage

Run container
```bash
make up
``` 
Run container in debug mode
```bash
make debug
```

## API Urls
- http://stayforlong.test:8080/api/v1/booking/maximize
- http://stayforlong.test:8080/api/v1/booking/stats
