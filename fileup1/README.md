# Hướng Dẫn Chạy Project Bằng Docker

## Yêu Cầu
- Cài đặt Docker và Docker Compose trên máy.
- Kiểm tra Docker đã hoạt động bằng lệnh: `docker --version`.

## Các Bước Thực Hiện

1. **Clone Repository**
    ```bash
    git clone <repository-url>
    cd <repository-folder>
    ```

2. **Cấu Hình Môi Trường**
    - Tạo file `.env` từ file mẫu `.env.example`:
      ```bash
      cp .env.example .env
      ```
    - Cập nhật các thông tin cần thiết trong file `.env`.

3. **Build và Chạy Container**
    - Build và chạy project:
      ```bash
      docker-compose up --build
      ```
    - Chạy ở chế độ nền:
      ```bash
      docker-compose up -d
      ```

4. **Kiểm Tra Container**
    - Xem danh sách container đang chạy:
      ```bash
      docker ps
      ```
    - Kiểm tra logs:
      ```bash
      docker-compose logs -f
      ```

5. **Truy Cập Ứng Dụng**
    - Mở trình duyệt và truy cập: `http://localhost:<port>` (port được cấu hình trong file `docker-compose.yml` hoặc `.env`).

## Lưu Ý
- Đảm bảo các port được sử dụng không bị xung đột với các ứng dụng khác.
- Nếu có lỗi, kiểm tra logs để tìm nguyên nhân.
- Dừng container khi không sử dụng:
  ```bash
  docker-compose down
  ```

## Kết Quả
- Sau khi chạy thành công, bạn sẽ thấy ứng dụng hoạt động trên trình duyệt.
- Các container liên quan sẽ được liệt kê khi chạy `docker ps`.
