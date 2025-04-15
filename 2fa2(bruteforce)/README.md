# README

## Hướng dẫn chạy project bằng Docker

### Yêu cầu
- Cài đặt [Docker](https://www.docker.com/) và [Docker Compose](https://docs.docker.com/compose/) trên máy của bạn.

### Các bước thực hiện

1. **Clone repository**
    ```bash
    git clone https://github.com/your-repo/khoaluandemo3.git
    cd khoaluandemo3/2fa2(bruteforce)
    ```

2. **Chạy ứng dụng bằng Docker Compose**
    ```bash
    docker-compose up -d
    ```

3. **Truy cập ứng dụng**
    - Ứng dụng chính: [http://localhost:8000](http://localhost:8000)
    - Các dịch vụ khác (nếu có): kiểm tra file `docker-compose.yml` để biết thêm thông tin.

### Ghi chú
- Đảm bảo các cổng được chỉ định trong `docker-compose.yml` không bị xung đột với ứng dụng khác.
- Nếu cần thay đổi cấu hình, chỉnh sửa file `docker-compose.yml` hoặc các file cấu hình liên quan.

### Dừng ứng dụng
Để dừng toàn bộ ứng dụng, chạy lệnh:
```bash
docker-compose down
```

### Xóa container và image
Nếu muốn xóa toàn bộ container và image, chạy lệnh:
```bash
docker-compose down --rmi all
```
